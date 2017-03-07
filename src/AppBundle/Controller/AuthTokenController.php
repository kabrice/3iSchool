<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 20/11/2016
 * Time: 11:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;
use AppBundle\Entity\User;
use AppBundle\Form\Type\CredentialsType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthTokenController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Post("/auth-tokens/{countClick}")
     */
    public function postAuthTokensAction(Request $request)
    {

        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);
        //$form->submit(array($request->request["login"],$request->request["password"] ));
        $form->submit($request->request->all(), false);

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->getDoctrine()->getEntityManager();

        $user = $em->getRepository('AppBundle:User')
            ->findOneByEmail($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        /*if (!$user->getActive()) { // L'utilisateur n'a pas activé son compte
            return $this->accountNotActivated();
        }*/



        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if($request->get("countClick")>3)
        {
            $captcha = $credentials->getGRecaptchaResponse(); //Captcha response send by client

            //Build post data to make request with fetch_file_contents
            $postdata = http_build_query(
                array(
                    'secret' => '6LfLyBAUAAAAAHy-mq02Sk1ukQ5SYEosEL_1nFc5', //secret key provided by google
                    'response' => $captcha,                    // g-captcha-response string sent from client
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            );

            //Build options for the post request
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            //Create a stream this is required to make post request with fetch_file_contents
            $context  = stream_context_create($opts);

            /* Send request to Googles siteVerify API */
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify",false,$context);
            $response = json_decode($response, true);

            $response["gRecaptchaResponse"]=$captcha;
            if($response["success"]===false) { //if user verification failed

                return $response;

            }
        }

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct

             $tab["credentials"] = false;
             return $tab;
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        return $authToken;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/auth-tokens/{id}")
     */
    public function removeAuthTokenAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $authToken = $em->getRepository('AppBundle:AuthToken')
            ->find($request->get('id'));


        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
            $em->remove($authToken);
            $em->flush();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }

    private function accountNotActivated()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Account not activated'], Response::HTTP_BAD_REQUEST);
    }
}
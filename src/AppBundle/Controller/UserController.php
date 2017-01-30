<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 10:52
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Conteneur;
use AppBundle\Entity\Contenu;
use AppBundle\Entity\ContenusGroupes;
use AppBundle\Entity\Rubrique;
use AppBundle\Entity\UserContenu;
use AppBundle\Form\Type\UserType;
use DateTime;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\User;

class UserController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/{email}")
     */
    public function getUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('AppBundle:User')->findByEmail($request->get('email'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $user;

    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Get("/users/checkPW/{user_email}")
     */
    public function getIsPasswordEmptyAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $em->getRepository('AppBundle:User')->findOneByEmail($request->get('user_email'));

        $tab["isPasswordEmpty"] = (!empty($user)) ? $this->get("app.user_service")->isPasswordEmpty($user) : "incorrect" ;
        if(!empty($user)) $tab["isPersonnel"] = $user->getIsPersonnel();
        if($tab["isPasswordEmpty"]===true) $tab["userID"] = $user->getId();
        return $tab ;

    }

    /**
     * @Rest\View(serializerGroups={"conteneur", "rubrique", "contenu", "user"})
     * @Rest\Get("/users/{user_id}/{annee_id}/{groupe_id}/{niveau_id}")
     */
    public function getConteneursAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $annee = $em->getRepository("AppBundle:Annee")->find($request->get('annee_id'));
        $groupe = $em->getRepository("AppBundle:Groupe")->find($request->get('groupe_id'));
        $niveau = $em->getRepository("AppBundle:Niveau")->find($request->get('niveau_id'));
        $user = $em->getRepository("AppBundle:User")->find($request->get('user_id'));



        if (empty($annee) || empty($groupe) | empty($niveau)) {
            return new JsonResponse(['message' => 'Conteneur introuvable'], Response::HTTP_NOT_FOUND);
        }


       $contenuFavoris = $em->getRepository("AppBundle:UserContenu")->findContenusFavoris($user);
       $contenuRecents = $em->getRepository("AppBundle:Conteneur")
            ->findContenusTries(array('annee'=>$annee,
                                      'groupe'=>$groupe,
                                      'niveau'=>$niveau), "datePublication");
       $contenuAussiConsultes = $em->getRepository('AppBundle:Conteneur')
            ->findContenusTries(array('annee'=>$annee,
                           'groupe'=>$groupe,
                           'niveau'=>$niveau), "nombreVueTotal");
        $tousLesContenusPromotion = $em->getRepository('AppBundle:UserContenu')
            ->findConteneurs(array('annee'=>$annee,
                'groupe'=>$groupe,
                'niveau'=>$niveau));;





        return array("FAVORIS"=>$contenuFavoris, "RECENTS"=>$contenuRecents,
                    "AUSSICONSULTES"=>$contenuAussiConsultes, "CONTENEUR"=>$tousLesContenusPromotion);

    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request, $clearMissing)
    {



            $user = $this->getDoctrine()->getEntityManager()
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));

            if (empty($user)) {
                return $this->userNotFound();
            }

            if(empty($user->getUserProfilRoot())){
                $user->setDateCreation(new DateTime());
            }

            if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
                $options = ['validation_groups'=>['Default', 'FullUpdate']];
            } else {
                $options = []; // Le groupe de validation par défaut de Symfony est Default
            }

            $form = $this->createForm(UserType::class, $user, $options);

            $form->submit($request->request->all(), $clearMissing);


            if ($form->isValid()) {

                //Recaptcha verification
                //Should be some validations before you proceed
                //Not in the scope of this tutorial.

                $captcha = $user->getGRecaptchaResponse(); //Captcha response send by client

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


                if($response["success"]===false) { //if user verification failed

                    return $response;

                }

                // Si l'utilisateur veut changer son mot de passe
                if (!empty($user->getPlainPassword())) {
                    $encoder = $this->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                    $validationCode = base64_encode(random_bytes(64));
                    $user->setValidationCode($validationCode);
                    $user->setPassword($encoded);
                    $this->sendEmailActivation($user->getPrenom(), $validationCode);
                }
                $em = $this->get('doctrine.orm.entity_manager');

                if(!empty($user->getCroppedDataUrl()))
                {
                    $data = $request->get('croppedDataUrl');
                    $file_name = $request->get('id')."_".date("Y_m_d")."_".date("h_i_sa")."_".$request->get('picFileName');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);

                    $type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);

                    file_put_contents("img/imgProfils/".$file_name, $data);
                    $user->setUserProfilRoot("img/imgProfils/".$file_name);

                }else{
                    $user->setUserProfilRoot("img/happystudent.png");
                }

                $em->merge($user);
                $em->flush();
                return $user;

            } else {
                return $form;
            }



        //End of verification


    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }

    private function accessForbidden()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Access Forbidden'], Response::HTTP_FORBIDDEN);
    }

    private function sendEmailActivation($name, $validationCode)
    {
     /*   $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'default/registration.html.twig',
                    array('name' => $name, 'activationCode' =>$validationCode)
                ),
                'text/html'
            )*/
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;
       // $this->get('mailer')->send($message);

        //return $this->render(...);
    }



}
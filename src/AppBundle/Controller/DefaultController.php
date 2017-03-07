<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Rubrique;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("3il/{username}", name="user")
     */
    public function userAction($username)
    {
        $email = $username."@3il.fr";
        return $this->render('default/profil.html.twig', ['email' => $email]);
    }

    /**
     * @Route("/lectureContenu/{idConteneur}", name="lectureContenu")
     */
    public function lectureContenuAction($idConteneur)
    {
        return $this->render('default/lectureContenu.html.twig', ['idConteneur' => $idConteneur]);
    }

    /**
     *  Activation du mail
     *
     * @Route("/verify/{userID}/{validationCode}", name="verifyEmail")
     */
    public function verifyAction($userID, $validationCode)
    {
        return $this->render('default/verify.html.twig', ['validationCode' => $validationCode, 'userID'=>$userID]);
    }

    /**
     * @Route("/forgotPassword", name="forgotPassword")
     */
    public function forgotPasswordAction()
    {
        return $this->render('default/forgotPassword.html.twig', []);
    }

    /**
     *
     *
     * @Route("/resetPassword/{userID}/{validationCode}", name="resetPassword")
     */
    public function resetPasswordAction($userID, $validationCode)
    {

        return $this->render('default/resetPassword.html.twig', ['validationCode' => $validationCode, 'userID'=>$userID]);
    }


    /**
     * @Route("/{userID}/dashboard", name="dashboard")
     */
    public function dashboardAction($userID)
    {
        return $this->render('default/dashboard.html.twig', ["userID"=>$userID]);
    }

}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 29/12/2016
 * Time: 04:16
 */

/***  ONLY FOR ANGULAR ***/

namespace AppBundle\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Rubrique;


class TemplateController extends Controller
{
    /**
     * @Route("/contenusRubrique", name="contenusRubrique")
     */
    public function contenusRubriqueAction()
    {
        return $this->render('angular-templates/contenus-rubrique.html.twig', []);
    }

    /**
     * @Route("/newQuestion", name="newQuestion")
     */
    public function newQuestionAction()
    {
        return $this->render('angular-templates/new-question.html.twig', []);
    }

    /**
     * @Route("/listeQuestions", name="listeQuestions")
     */
    public function listeQuestionsAction()
    {
        return $this->render('angular-templates/liste-questions.html.twig', []);
    }



    /**
     * @Route("/reponsesQuestion", name="reponsesQuestion")
     */
    public function reponsesQuestionAction()
    {
        return $this->render('angular-templates/reponses-question.html.twig', []);
    }

    /**
     * @Route("/commentairesReponse", name="commentairesReponse")
     */
    public function commentairesReponseAction()
    {
        return $this->render('angular-templates/commentaires-reponse.html.twig', []);
    }

    /**
     * @Route("/contenusTries", name="contenusTries")
     */
    public function contenusTriesAction()
    {
        return $this->render('angular-templates/contenus-tries.html.twig', []);
    }

    /**
     * @Route("/authentification", name="authentification")
     */
    public function authentificationAction()
    {
        return $this->render('angular-templates/authentification.html.twig', []);
    }

    /**
     * @Route("/administration", name="administration")
     */
    public function administrationAction()
    {
        return $this->render('angular-templates/administration.html.twig', []);
    }

    /**
     * @Route("/review", name="review")
     */
    public function reviewAction()
    {
        return $this->render('angular-templates/review.html.twig', []);
    }

    /**
     * @Route("/chart", name="chart")
     */
    public function chartAction()
    {
        return $this->render('angular-templates/chart.html.twig', []);
    }

    /**
     * @Route("/questionManager", name="questionManager")
     */
    public function questionManagerAction()
    {
        return $this->render('angular-templates/questionManager.html.twig', []);
    }

    /**
     * @Route("/contenusSignales", name="contenusSignales")
     */
    public function contenusSignalesAction()
    {
        return $this->render('angular-templates/contenusSignales.html.twig', []);
    }

    /**
     * @Route("/mesCours", name="mesCours")
     */
    public function mesCoursAction()
    {
        return $this->render('angular-templates/mesCours.html.twig', []);
    }

    /**
     * @Route("/sousRubriqueDashboard", name="sousRubriqueDashboard")
     */
    public function SousRubriqueDashboardAction()
    {
        return $this->render('angular-templates/sousRubriqueDashboard.html.twig', []);
    }

    /**
     * @Route("/modalPromotionNotification", name="modalPromotionNotification")
     */
    public function modalPromotionNotificationAction()
    {
        return $this->render('angular-templates/modalPromotionNotification.html.twig');
    }

}
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
    public function contenusRubriqueAction(Request $request)
    {
        return $this->render('angular-templates/contenus-rubrique.html.twig', []);
    }

    /**
     * @Route("/newQuestion", name="newQuestion")
     */
    public function newQuestionAction(Request $request)
    {
        return $this->render('angular-templates/new-question.html.twig', []);
    }
}
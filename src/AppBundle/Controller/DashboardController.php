<?php
/**
 * Created by IntelliJ IDEA.
 * User: MS
 * Date: 01/01/2017
 * Time: 11:32
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Question;
use AppBundle\Entity\Reponse;
use AppBundle\Form\Type\CommentaireType;
use AppBundle\Form\Type\QuestionType;
use AppBundle\Form\Type\ReponseType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"contenu", "reponse"})
     * @Rest\Post("/ecritureContenu")
     */
    private function postContenuAction()
    {
        $promotion = new Annee
    }
}
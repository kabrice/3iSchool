<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 01/01/2017
 * Time: 09:00
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PromotionController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"annee"})
     * @Rest\Get("promotion/annees")
     */
    public function getAnneeAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $annee = $em->getRepository('AppBundle:Annee')->findAll();

        if (empty($annee)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Annee introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $annee;
    }

    /**
     * @Rest\View(serializerGroups={"groupe"})
     * @Rest\Get("promotion/groupes")
     */
    public function getGroupeAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $groupe = $em->getRepository('AppBundle:Groupe')->findAll();

        if (empty($groupe)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Groupe introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $groupe;
    }

    /**
     * @Rest\View(serializerGroups={"niveau"})
     * @Rest\Get("promotion/niveaux")
     */
    public function getNiveauAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $niveau = $em->getRepository('AppBundle:Niveau')->findAll();

        if (empty($niveau)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Niveau introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $niveau;
    }
}
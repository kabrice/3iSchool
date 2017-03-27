<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 01/01/2017
 * Time: 09:00
 */

namespace AppBundle\Controller;

use AppBundle\Entity\PromotionNotification;
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

    /**
     * @Rest\View(serializerGroups={"rubrique"})
     * @Rest\Get("promotion/rubriques")
     */
    public function getRubriqueAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $rubrique = $em->getRepository('AppBundle:Rubrique')->findBy([],array("libelle"=>"ASC"));

        if (empty($rubrique)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Rubrique introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $rubrique;
    }

    /**
     * @Rest\View(serializerGroups={"sousRubrique"})
     * @Rest\Get("promotion/sousRubriques")
     */
    public function getSousRubriqueAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $sousRubrique = $em->getRepository('AppBundle:SousRubrique')->findAll();

        if (empty($sousRubrique)) {
            return \FOS\RestBundle\View\View::create(['message' => 'SousRubrique introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $sousRubrique;
    }

    /**
     * @Rest\View(serializerGroups={"promotionNotification", "annee", "groupe", "niveau"})
     * @Rest\Get("promotionNotification/{user_id}")
     */
    public function getPromotionNotificationAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository("AppBundle:User")->find($request->get('user_id'));

        $promotionNotification = $em->getRepository('AppBundle:PromotionNotification')
                                    ->findOneBy(array("user"=>$user));

        if (empty($promotionNotification)) {
            $promotionNotification["id"]=0;
        }

        return $promotionNotification;
    }

    /**
     * @Rest\View(serializerGroups={"promotionNotification"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/promotionNotification/{annee_id}/{groupe_id}/{niveau_id}/{user_id}")
     */
    public function postPromotionNotificationAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();

        $annee = $em->getRepository("AppBundle:Annee")->find($request->get('annee_id'));
        $groupe = $em->getRepository("AppBundle:Groupe")->find($request->get('groupe_id'));
        $niveau = $em->getRepository("AppBundle:Niveau")->find($request->get('niveau_id'));
        $user = $em->getRepository("AppBundle:User")->find($request->get('user_id'));

        $promotionNotification = new PromotionNotification();

        $promotionNotification->setAnnee($annee)->setGroupe($groupe)->setNiveau($niveau)->setUser($user);
        $annee->addPromotionNotification($promotionNotification);
        $groupe->addPromotionNotification($promotionNotification);
        $niveau->addPromotionNotification($promotionNotification);
        $user->addPromotionNotification($promotionNotification);



            $em->persist($promotionNotification);
            $em->persist($annee);
            $em->persist($groupe);
            $em->persist($niveau);
            $em->persist($user);
            $em->flush();
            return $promotionNotification;



    }

    /**
     * @Rest\View(serializerGroups={"promotionNotification"})
     * @Rest\Patch("/promotionNotification/{promotionNotification_id}/{annee_id}/{groupe_id}/{niveau_id}/{user_id}")
     */
    public function patchPromotionNotificationAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $promotionNotification = $em->getRepository('AppBundle:PromotionNotification')->find($request->get('promotionNotification_id'));

        if (empty($promotionNotification)) {
            return \FOS\RestBundle\View\View::create(['message' => 'PromotionNotification introuvable'], Response::HTTP_NOT_FOUND);
        }

        $annee = $em->getRepository("AppBundle:Annee")->find($request->get('annee_id'));
        $groupe = $em->getRepository("AppBundle:Groupe")->find($request->get('groupe_id'));
        $niveau = $em->getRepository("AppBundle:Niveau")->find($request->get('niveau_id'));
        $user = $em->getRepository("AppBundle:User")->find($request->get('user_id'));

        $promotionNotification->setAnnee($annee)->setGroupe($groupe)->setNiveau($niveau)->setUser($user);
        $annee->addPromotionNotification($promotionNotification);
        $groupe->addPromotionNotification($promotionNotification);
        $niveau->addPromotionNotification($promotionNotification);
        $user->addPromotionNotification($promotionNotification);



        $em->merge($promotionNotification);
        $em->merge($annee);
        $em->merge($groupe);
        $em->merge($niveau);
        $em->merge($user);
        $em->flush();
        return $promotionNotification;

    }
}
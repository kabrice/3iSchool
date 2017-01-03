<?php
/**
 * Created by IntelliJ IDEA.
 * User: MS
 * Date: 01/01/2017
 * Time: 11:32
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Annee;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Conteneur;
use AppBundle\Entity\Contenu;
use AppBundle\Entity\Niveau;
use AppBundle\Entity\Question;
use AppBundle\Entity\Reponse;
use AppBundle\Entity\Rubrique;
use AppBundle\Entity\SousRubrique;
use AppBundle\Entity\UserContenu;
use AppBundle\Form\Type\CommentaireType;
use AppBundle\Form\Type\ContenuType;
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
     * @Rest\View(serializerGroups={"annee", "groupe", "niveau", "rubrique", "sousRubrique", "user"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/ecritureContenu/{annee_id}/{groupe_id}/{niveau_id}/{rubrique_id}/{sous_rubrique_id}/{user_id}/Contenu")
     */
    public function postEcritureContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $annee      = $em->getRepository('AppBundle:Annee')->find($request->get('annee_id'));
        $niveau     = $em->getRepository('AppBundle:Niveau')->find($request->get('niveau_id'));
        $groupe     = $em->getRepository('AppBundle:Groupe')->find($request->get('groupe_id'));
        $rubrique   = $em->getRepository('AppBundle:Rubrique')->find($request->get('rubrique_id'));
        $sousRubrique   = $em->getRepository('AppBundle:SousRubrique')->find($request->get('sous_rubrique_id'));
        $user       = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        $contenu    = new Contenu();
        $conteneur = new Conteneur();
        $userContenu = new UserContenu();

        if(empty($annee) || empty($niveau) || empty($groupe) || empty($user) || empty($rubrique) || empty($sousRubrique))
            return new JsonResponse(['message' => 'Contenu introuvable.'], Response::HTTP_NOT_FOUND);

        $conteneur->setContenu($contenu)
            ->setAnnee($annee)
            ->setGroupe($groupe)
            ->setNiveau($niveau);

        $contenu->setRubrique($rubrique)
            ->setSousRubrique($sousRubrique);

        $userContenu->setUser($user)
        ->setContenu($contenu)
            ->setAPublie(1)
            ->setNbreVue(1);

        $form = $this->createForm(ContenuType::class, $contenu);
        $form->submit($request->request->all());

        if($form->isValid()) {
            $em->persist($conteneur);
            $em->persist($contenu);
            $em->persist($userContenu);
            $em->flush();

            return $contenu;
        }
        else {
            return $form;
        }
    }
}
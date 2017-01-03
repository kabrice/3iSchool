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
     * @Rest\Get("/users/{id}")
     */
    public function getEtudiantAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('AppBundle:User')->findUserOnlyWithCredentials($request->get('id'));

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

        if ($user->getActive()) {
            return $this->accessForbidden();
        }



        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
    }

    private function accessForbidden()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Acces interdit'], Response::HTTP_FORBIDDEN);
    }

}
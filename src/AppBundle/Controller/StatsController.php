<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 31/01/2017
 * Time: 08:29
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserContenu;
use AppBundle\Entity\VisiteContenu;
use AppBundle\Entity\Vote;
use AppBundle\Form\Type\UserContenuType;
use AppBundle\Form\Type\VisiteContenuType;
use AppBundle\Form\Type\VoteType;
use DateTime;
use Proxies\__CG__\AppBundle\Entity\Contenu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatsController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"question"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/vote")
     */
    public function postCheckAction(Request $request)
    {

        $myfile = fopen("testfile.txt", "w");
        fwrite($myfile, $request->get('timeSpentOnPage'));
        return print_r($request->get('timeSpentOnPage'));

        $form = true;
        $em = $this->getDoctrine()->getEntityManager();
        $ref = $request->get('ref');
        $refID = $request->get('refID');
        $userID = $request->get('userID');
        $vote = $em->getRepository('AppBundle:Vote')->findOneBy(array("ref"=>$ref, "refID"=>$refID, "userID"=>$userID));

        $refEntity = $em->getRepository('AppBundle:'.$ref)->find($refID);

        $nbreLike = $refEntity->getNombreLike();
        if(!empty($vote))
        {

            $em->remove($vote);
            $refEntity->setNombreLike($nbreLike-1);
            $em->persist($refEntity);
            $em->flush();
            return $refEntity;

        }else{
            $vote = new Vote();
            $vote->setRef($ref)
                ->setUserID($userID)
                ->setRefID($refID)
                ->setValeur(1);
            $form = $this->createForm(VoteType::class, $vote);
            $form->submit($request->request->all());
            $refEntity->setNombreLike($nbreLike+1);
            if ($form->isValid()) {

                $em->persist($refEntity);
                $em->persist($vote);
                $em->flush();
                return $refEntity;

            } else {
                return $form;
            }
        }
    }



    /**
     * @Rest\View(serializerGroups={"contenu", "vote"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Patch("/rate")
     */
    public function patchRatingAction(Request $request)
    {
        $form = null;
        $voted = false;
        $em = $this->getDoctrine()->getEntityManager();
        $ref = $request->get('ref');
        $refID = $request->get('refID');
        $valeur = $request->get('valeur');
        $userID = $request->get('userID');
        $vote = $em->getRepository('AppBundle:Vote')->findOneBy(array("ref"=>$ref, "refID"=>$refID, "userID"=>$userID));

        $contenu = $em->getRepository('AppBundle:'.$ref)->find($refID);

        $notes=[];

        if(!empty($vote))
        {
            if($valeur == $vote->getValeur())
            {
                $voted["sameVote"] = true;
                return $voted;
            }
            $voted = true;
            $vote->setValeur($valeur);

        }else{

            $vote = new Vote();
            $vote->setRef($ref)
                ->setUserID($userID)
                ->setRefID($refID)
                ->setValeur($valeur);

            $form = $this->createForm(VoteType::class, $vote);

            $form->submit($request->request->all());

        }

        if ($voted || $form->isValid()) {

            $contenuNotes = $em->getRepository('AppBundle:Vote')->findBy(array("ref"=>$ref, "refID"=>$refID));

            foreach ($contenuNotes as $contenuNote) {

                $notes[] = $contenuNote->getValeur();
            }

            if($voted)
            {

                $contenu->setNbreNoteur(count($notes));
                $nbreNoteur = $contenu->getNbreNoteur();
                $note = (array_sum($notes))/$nbreNoteur;

            }else{

                $contenu->setNbreNoteur(count($notes)+1);
                $nbreNoteur = $contenu->getNbreNoteur();
                $note = (array_sum($notes)+$valeur)/$nbreNoteur;

            }

            $contenu->setNote($note);
            $em->persist($contenu);
            $em->persist($vote);
            $em->flush();
            return $contenu;

        } else {
            return $form;
        }
    }


    /**
     * @Rest\View(serializerGroups={"userContenu", "user"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Patch("/usercontenu/{user_id}/{contenu_id}")
     */
    public function patchUserContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        $userContenu =  $em->getRepository('AppBundle:UserContenu')->findOneBy(array("user"=>$user, "contenu"=>$contenu));

        if (empty($user)) {
            return $this->userNotFound();
        }

        if (empty($contenu)) {
            return $this->contenuNotFound();
        }

        if(empty($userContenu))
        {
            return $this->postUserContenu($request);

        }else{
            /*
            if(!empty($request->get('nbreVue')) && $userContenu->getNbreVue() <= $request->get('nbreVue')) {
                $userContenu->setNbreVue($request->get('nbreVue'));
                $nbreVueTotalContenu = $contenu->getNombreVueTotal();
                $contenu->setNombreVueTotal($nbreVueTotalContenu+1);
                $em->persist($contenu);
            }*/

            $form = $this->createForm(UserContenuType::class, $userContenu, []);
            $form->submit($request->request->all(), false);

            if ($form->isValid()) {
                $em->persist($userContenu);
                $em->flush();
                return $userContenu;
            } else {
                return $form;
            }
        }
    }

    private function postUserContenu(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        $userContenu = new UserContenu();

        $userContenu->setUser($user);
        $userContenu->setContenu($contenu);

        $contenu->addUserContenus($userContenu);
        $contenu->setNombreVueTotal(1+$contenu->getNombreVueTotal());
        $user->addUserContenus($userContenu);


        $form = $this->createForm(UserContenuType::class, $userContenu);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em->persist($userContenu);
            $em->persist($contenu);
            $em->persist($user);
            $em->flush();
            return $userContenu;

        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerGroups={"vote"})
     * @Rest\Get("/vote/{ref_id}/{ref}/{user_id}")
     */
    public function getVoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $vote = $em->getRepository('AppBundle:Vote')->findOneBy(array("ref"=>$request->get('ref')
                                                                                , "refID"=>$request->get('ref_id')
                                                                                            , "userID"=>$request->get('user_id')));

        if(empty($vote))
        {
            $vote["valeur"]=0;
        }
        return $vote ;

    }



    /**
     * @Rest\View(serializerGroups={"userContenu"})
     * @Rest\Get("/userContenu/{user_id}/{contenu_id}")
     */
    public function getUserContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));

        $userContenu = $em->getRepository('AppBundle:UserContenu')->findOneBy(array("contenu"=>$contenu, "user"=>$user));

        if(empty($userContenu))
        {
            return \FOS\RestBundle\View\View::create(['message' => 'UserContenu not found'], Response::HTTP_NOT_FOUND);
        }
        return $userContenu ;

    }

    /**
     * @Rest\View(serializerGroups={"visiteContenu"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/visiteContenu/{contenu_id}/{user_id}")
     */
    public function postVisiteContenuAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        $visiteContenu = $em->getRepository('AppBundle:VisiteContenu')->findLastVisiteContenuByDate($request->get('user_id'), $request->get('contenu_id'));


        if($user->getIsPersonnel()) return false;

        if (empty($user)) {
            return $this->userNotFound();
        }

        if (empty($contenu)) {
            return $this->contenuNotFound();
        }

        $newDate = json_decode($request->get('stringDate'));

        $inputDate = date("Y-m-d", strtotime($newDate));
        $lastDate = date("Y-m-d", strtotime($visiteContenu["date_visite"]));

        $date1=date_create($inputDate);
        $date2=date_create($lastDate);


        $diff= date_diff($date1,$date2, true);

        $this->patchUserContenuAction($request);

        if(!is_null($visiteContenu["id"]) && $diff->format("%a") == 0 )
        {

            return $this->updateVisiteContenuAction($request, $visiteContenu["id"]);

        }

        $visiteContenu= new VisiteContenu();

        $visiteContenu->setUser($user);
        $visiteContenu->setContenu($contenu);

        $contenu->addVisiteContenus($visiteContenu);
        $user->addVisiteContenus($visiteContenu);


        $form = $this->createForm(VisiteContenuType::class, $visiteContenu);
        //return $request->get('dateVisite');

        /*$form->submit(array($newDate));
        $form->submit($request->get('duree'));*/
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {

            $em->persist($visiteContenu);
            $em->persist($contenu);
            $em->persist($user);
            $em->flush();
            return $visiteContenu;

        } else {
            return $form;
        }
    }

    private function updateVisiteContenuAction(Request $request, $visiteContenuID)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $visiteContenu = $em->getRepository('AppBundle:VisiteContenu')->find($visiteContenuID);
        $lastDuree = $visiteContenu->getDuree();
        $visiteContenu->setDuree($lastDuree+$request->get("duree"));

        $em->merge($visiteContenu);
        $em->flush();
        return $visiteContenu;
    }

    /**
     * @Rest\View(serializerGroups={"visiteContenu", "user"})
     * @Rest\Get("/visiteContenu/user/{user_id}/contenu/{contenu_id}")
     */
    public function getVisiteContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));

        $visiteContenus = $em->getRepository('AppBundle:VisiteContenu')->findBy(array("contenu"=>$contenu, "user"=>$user), array('dateVisite' => 'ASC'));

        if(empty($visiteContenus))
        {
            $visiteContenus["duree"]=0;
            $visiteContenus = array($visiteContenus);
           // return \FOS\RestBundle\View\View::create(['message' => 'VisiteContenu not found'], Response::HTTP_NOT_FOUND);
        }

        return $visiteContenus ;

    }

    /**
     * @Rest\View(serializerGroups={"contenu", "user"})
     * @Rest\Get("/userContenu/user/contenu/{contenu_id}")
     */
    public function getUserContenuByContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));

        $userContenus = $em->getRepository('AppBundle:UserContenu')->findBy(array("contenu"=>$contenu, "aPublie"=>false));

        if(empty($userContenus))
        {

            /*$userContenus["user"]=array("email"=>"none@3il.fr");
            $userContenus["nbreVue"]=0;
            $userContenus["review"]="";*/
            $userContenus = null;
            //return \FOS\RestBundle\View\View::create(['message' => 'VisiteContenu not found'], Response::HTTP_NOT_FOUND);
        }

        return $userContenus ;

    }

    /**
     * @Rest\View(serializerGroups={"visiteContenu"})
     * @Rest\Get("/visiteContenu/contenu/{contenu_id}")
     */
    public function getAllVisiteContenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));

        $visiteContenus = $em->getRepository('AppBundle:VisiteContenu')->findAllVisiteContenuByDate($contenu);

        if(empty($visiteContenus))
        {

            $visiteContenus["dateVite"]="01-03-2017";
            $visiteContenus["dureeTotale"]=0;

            $visiteContenus = array($visiteContenus);
            //return \FOS\RestBundle\View\View::create(['message' => 'VisiteContenu not found'], Response::HTTP_NOT_FOUND);
        }

        return $visiteContenus ;

    }





    private function contenuNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'contenu not found'], Response::HTTP_NOT_FOUND);
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }



}
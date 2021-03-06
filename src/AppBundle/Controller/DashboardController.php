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
use AppBundle\Entity\Notification;
use AppBundle\Entity\Notifier;
use AppBundle\Entity\Question;
use AppBundle\Entity\Reponse;
use AppBundle\Entity\Rubrique;
use AppBundle\Entity\SousRubrique;
use AppBundle\Entity\TypeQuestion;
use AppBundle\Entity\User;
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

const QUESTIONS_ETUDIANTS = 1;
const QUESTIONS_SIGNALEES  = 2;
const REPONSES_SIGNALEES  = 3;
const COMMENTAIRES_SIGNALES  = 4;
const CONTENUS_ENSEIGNANT  = 5;

class DashboardController extends Controller
{


    /**
     * @Rest\View(serializerGroups={"annee", "groupe", "niveau", "rubrique", "sousRubrique", "user"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/conteneur/{annee_id}/{rubrique_id}/{sous_rubrique_id}/{user_id}")
     */
    public function postConteneurAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $annee      = $em->getRepository('AppBundle:Annee')->find($request->get('annee_id'));
        $rubrique   = $em->getRepository('AppBundle:Rubrique')->find($request->get('rubrique_id'));
        $sousRubrique   = $em->getRepository('AppBundle:SousRubrique')->find($request->get('sous_rubrique_id'));
        $user       = $em->getRepository('AppBundle:User')->find($request->get('user_id'));

        $listeGroupes = $request->get('listeGroupes');
        $listeNiveaux = $request->get('listeNiveaux');

        $usersTemp = [];

        if(empty($annee)  || empty($user) || empty($rubrique) || empty($sousRubrique))
            return new JsonResponse(['message' => 'Entity not found'], Response::HTTP_NOT_FOUND);

        if($request->get('imgB64') != null)
        {
            $data = $request->get('imgB64');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);

            file_put_contents($request->get('imageRoot'), $data);
        }

        $contenu    = new Contenu();

        $userContenu = new UserContenu();
        $listeconteneurs[]=null; $test[]=null;

        $form = $this->createForm(ContenuType::class, $contenu);
        $form->submit($request->request->all());
        if($form->isValid()) {
            foreach ($listeNiveaux as $unNiveau) {

                $niveau = $em->getRepository('AppBundle:Niveau')->find($unNiveau["id"]);

                foreach ($listeGroupes as $unGroupe) {
                    $conteneur = new Conteneur();
                    $groupe = $em->getRepository('AppBundle:Groupe')->find($unGroupe["id"]);
                    $conteneur->setContenu($contenu)
                        ->setAnnee($annee)
                        ->setGroupe($groupe)
                        ->setNiveau($niveau);
                    $contenu->setRubrique($rubrique)
                        ->setSousRubrique($sousRubrique);
                    $userContenu->setUser($user)
                        ->setContenu($contenu)
                        ->setAPublie(true)
                        ->setContenu($contenu)
                        ->setAPublie(1)
                        ->setNbreVue(1);

                    //Création de notifications
                    $notification = new Notification();
                    $notification->setAnnee($annee)->setNiveau($niveau)->setGroupe($groupe)->setUser($user)->setContenu($contenu)->setCode("P");


                    $em->persist($conteneur);
                    $em->persist($contenu);
                    $em->persist($userContenu);
                    $em->persist($notification);
                    $em->flush();

                    // Envoie de notifications aux users concernés
                    $promotionNotifications =$em->getRepository('AppBundle:PromotionNotification')
                        ->findBy(array("annee"=>$annee, "niveau"=>$niveau, "groupe"=>$groupe));

                    if(!empty($promotionNotifications))
                    {

                        foreach($promotionNotifications as $promotionNotification)
                        {
                           
                            if(!in_array($promotionNotification->getUser(), $usersTemp))
                            {
                                $this->sendNotification($promotionNotification->getUser(), $notification);
                                $this->sendEmailPublicationContenu($promotionNotification->getUser()->getEmail(),
                                                                    $promotionNotification->getUser()->getPrenom(),
                                                                        $user->getPrenom()." ".$user->getNom(),
                                                                            $contenu->getId(),
                                                                                $contenu->getTitre());
                                $usersTemp[] = $promotionNotification->getUser();
                            }
                            
                        }

                    }


                    $listeconteneurs[] = $conteneur;


                }
            }
            return $listeconteneurs;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/contenu/{contenu_id}")
     */
    private function patchContenu(Request $request, $entityName)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository("AppBundle:Contenu")
            ->find($request->get('contenu_id'));

        if(empty($contenu)) {
            return \FOS\RestBundle\View\View::create(["message" => "Contenu not found"], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ContenuType::class, $contenu);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em->persist($contenu);
            $em->flush();
            return $contenu;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Get("/user/{user_id}/{num_rubrique}/contenus/questions/reponses")
     */
    public function getRubriqueDashboardAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        $questionsEtudiants = $em->getRepository('AppBundle:Contenu')->findQuestionsEtudiants($user);
        $questionsSignales = $em->getRepository('AppBundle:UserContenu')->findQuestionsSignalees($user);
        $contenusEnseignant = $em->getRepository('AppBundle:UserContenu')->findContenusEnseignant($user);
        $reponsesSignalees = $em->getRepository('AppBundle:UserContenu')->findReponsesSignalees($user);
        $commentairesSignales = $em->getRepository('AppBundle:UserContenu')->findCommentairesSignales($user);


        switch ($request->get('num_rubrique')) {
            case QUESTIONS_ETUDIANTS:
                return $questionsEtudiants;
            case QUESTIONS_SIGNALEES:
                return $questionsSignales;
            case REPONSES_SIGNALEES:
                return $reponsesSignalees;
            case COMMENTAIRES_SIGNALES:
                return $commentairesSignales;
            case CONTENUS_ENSEIGNANT:
                return $contenusEnseignant;
            default:
                return false;
        }

    }

    /**
     * @Rest\View(serializerGroups={"userContenu"})
     * @Rest\Get("/contenu/{contenu_id}/{user_id}/review")
     */
    public function getUserReviewAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:User')->find($request->get('contenu_id'));
        $user = $em->getRepository('AppBundle:User')->find($request->get('user_id'));
        return $em->getRepository('AppBundle:UserContenu')->findBy(array("user"=>$user, "contenu"=>$contenu));

    }

    /**
     * @Rest\View(serializerGroups={"vote"})
     * @Rest\Get("/contenu/{contenu_id}/{user_id}/note")
     */
    public function getUserNoteAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        return  $em->getRepository('AppBundle:Vote')->findBy(array("userID"=>$request->get('user_id'),
            "refID"=>$request->get('contenu_id'),
            "ref"=>'Contenu'));

    }

    private  function sendNotification(User $user, Notification $notification)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $notifier = new Notifier();
        $notifier->setUser($user)->setNotification($notification);
        $em->persist($notifier);
        $em->flush();

    }

    private function sendEmailPublicationContenu($email, $name, $enseignant, $idContenu, $titreContenu)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($enseignant.' vient de publier un contenu')
            ->setFrom('noreply@3ilcours.fr')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'default/publier-cours-email.html.twig',
                    array('name' => $name, 'enseignant'=>$enseignant, 'email' =>$email, 'idContenu'=>$idContenu, 'titreContenu'=>$titreContenu)
                ),
                'text/html'
            )

            //If you also want to include a plaintext version of the message
            /*  ->addPart(
                  $this->renderView(
                      'Emails/registration.txt.twig',
                      array('name' => $name)
                  ),
                  'text/plain'
              )*/

        ;
        $this->get('mailer')->send($message);

        //return $this->render(...);
    }

}
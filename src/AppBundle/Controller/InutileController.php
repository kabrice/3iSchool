<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/02/2017
 * Time: 21:37
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Contenu;
use AppBundle\Entity\Inutile;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Notifier;
use AppBundle\Entity\Question;
use AppBundle\Entity\Reponse;
use AppBundle\Entity\User;
use AppBundle\Form\Type\InutileType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InutileController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"question", "notification"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/inutile")
     */
    public function postInutileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $ref = $request->get('ref');
        $refID = $request->get('refID');
        $userID = $request->get('userID');
        $inutile= $em->getRepository('AppBundle:Inutile')->findOneBy(array("ref"=>$ref, "refID"=>$refID, "userID"=>$userID));

        $refEntity = $em->getRepository('AppBundle:'.$ref)->find($refID);

        $nbreInutile= $refEntity->getNbreInutile();

        if(!empty($inutile))
        {
            $em->remove($inutile);
            $refEntity->setNbreInutile($nbreInutile-1);

            $em->persist($refEntity);
            $em->flush();
            return $refEntity;

        }else{
            $inutile = new Inutile();
            $contenu = null;
            $inutile->setRef($ref)
                ->setUserID($userID)
                ->setRefID($refID);

            $form = $this->createForm(InutileType::class, $inutile);

            $form->submit($request->request->all());

            $refEntity->setNbreInutile($nbreInutile+1);

            if ($form->isValid()) {
                       $notification = new Notification();
                       $user = $em->getRepository('AppBundle:User')->find($userID);
                switch ($ref) {

                    case 'Question':
                        $contenu = $refEntity->getContenu();
/*
                        $previousNotification = $em->getRepository('AppBundle:Notification')->findOneBy(array("question"=>$refEntity, "code"=>"Sq"));
                        if(!empty($previousNotification)) {
                            return $previousNotification;
                            $em->remove($previousNotification);
                            $em->persist($previousNotification);
                            $em->flush();
                        }*/

                        $previousNotif = $em->getRepository('AppBundle:Notification')->findOneBy(
                            array("contenu"=>$contenu,
                                "question"=>$refEntity,  "code"=>"Sq" ));
                        
                        if(!empty($previousNotif)) {
                            $em->remove($previousNotif);
                            $em->flush();
                        }

                        $notification->setUser($user)->setContenu($contenu)->setQuestion($refEntity)->setInutile($inutile)->setCode("Sq");
                        break;

                    case 'Reponse':

                        $contenu = $refEntity->getQuestion()->getContenu();

                        $previousNotif = $em->getRepository('AppBundle:Notification')->findOneBy(
                            array("contenu"=>$contenu,
                                "reponse"=>$refEntity,  "code"=>"Sr" ));

                        if(!empty($previousNotif)) {
                            $em->remove($previousNotif);
                            $em->flush();
                        }

                        $notification->setUser($user)->setContenu($contenu)->setReponse($refEntity)->setInutile($inutile)->setCode("Sr");
                        break;

                    case 'Commentaire':

                        $contenu = $refEntity->getReponse()->getQuestion()->getContenu();

                        $previousNotif = $em->getRepository('AppBundle:Notification')->findOneBy(
                            array("contenu"=>$contenu,
                                "commentaire"=>$refEntity,  "code"=>"Sc" ));

                        if(!empty($previousNotif)) {
                            $em->remove($previousNotif);
                            $em->flush();
                        }

                        $notification->setUser($user)->setContenu($contenu)->setCommentaire($refEntity)->setInutile($inutile)->setCode("Sc");
                        break;

                    default:
                        break;
                }
                $em->persist($refEntity);
                $em->persist($inutile);
                $em->persist($notification);
                $em->flush();

                $userContenuTemp = $em->getRepository('AppBundle:UserContenu')->findOneBy(array("contenu"=>$contenu, "aPublie"=>true));
                $enseignant = $userContenuTemp->getUser();

                if($user->getId()!=$enseignant->getId())
                {
                    $this->sendNotification($enseignant, $notification);
                    switch ($ref) {

                        case 'Question':

                            $this->sendEmailElementSignalee($enseignant->getEmail(), $enseignant->getPrenom(), $refEntity->getNbreInutile(),
                                                            $contenu->getId(), $contenu->getTitre(), $refEntity->getId(), $refEntity->getLibelle(),
                                                            strtolower($ref));
                         break;

                        case 'Reponse':

                            $this->sendEmailElementSignalee($enseignant->getEmail(), $enseignant->getPrenom(), $refEntity->getNbreInutile(),
                                $contenu->getId(), $contenu->getTitre(), $refEntity->getQuestion()->getId(), $refEntity->getLibelle(),
                                strtolower($ref));
                        break;

                        case 'Commentaire':
                            $this->sendEmailCommentaireSignalee($enseignant->getEmail(), $enseignant->getPrenom(), $refEntity->getNbreInutile(),
                                $contenu->getId(), $contenu->getTitre(), $commentaire->getReponse()->getQuestion()->getId(), $refEntity->getLibelle(),
                                strtolower($ref));
                        break;

                        default:
                            break;
                    }

                }


                return $refEntity;

            } else {
                return $form;
            }
        }
    }


    private  function sendNotification(User $user, Notification $notification)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $notifier = new Notifier();
        $notifier->setUser($user)->setNotification($notification);
        $em->persist($notifier);
        $em->flush();

    }

    private function sendEmailElementSignalee($email, $name, $nbre, $idContenu, $titreContenu, $idQuestion, $libelleRef, $ref)
    {
        if($nbre>1)
        {
            $subMessage = $nbre.'utilisateurs ont';
        }else{
            $subMessage = '1 utilisateur a';
        }
        $message = \Swift_Message::newInstance()
            ->setSubject($subMessage." signalé une $ref")
            ->setFrom('noreply@3ilcours.fr')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'default/elementSignale-email.html.twig',
                    array('name' => $name, 'email' =>$email, 'subMessage'=>$subMessage, 'idContenu'=>$idContenu,
                        'titreContenu'=>$titreContenu, "idQuestion"=>$idQuestion, "libelleRef"=>$libelleRef, "ref"=>$ref)
                ),
                'text/html'
            )

        ;
        $this->get('mailer')->send($message);

    }

    private function sendEmailCommentaireSignalee($email, $name, $nbre, $idContenu, $titreContenu, $idQuestion, $libelleCommentaire, $ref)
    {
        if($nbre>1)
        {
            $subMessage = $nbre.'utilisateurs ont';
        }else{
            $subMessage = '1 utilisateur a';
        }
        $message = \Swift_Message::newInstance()
            ->setSubject($subMessage." signalé un commentaire")
            ->setFrom('noreply@3ilcours.fr')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'default/commentaireSignale-email.html.twig',
                    array('name' => $name, 'email' =>$email, 'subMessage'=>$subMessage, 'idContenu'=>$idContenu,
                        'titreContenu'=>$titreContenu, "idQuestion"=>$idQuestion, "libelleCommentaire"=>$libelleCommentaire)
                ),
                'text/html'
            )

        ;
        $this->get('mailer')->send($message);

    }

}
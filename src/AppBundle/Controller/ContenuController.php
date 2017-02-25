<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 17:37
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

class ContenuController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"conteneur", "contenu", "question"})
     * @Rest\Get("/lectureConteneur/{id}")
     */
    public function getConteneurAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $conteneur = $em->getRepository('AppBundle:Conteneur')->find($request->get('id'));

        if (empty($conteneur)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Conteneur introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $conteneur;
    }



    /**
     * @Rest\View(serializerGroups={"contenu", "user"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/lectureContenu/{contenu_id}/{user_id}/{type_question_id}/Questions")
     */
    public function postQuestionAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('contenu_id'));
        $typeQuestion = $em->getRepository('AppBundle:TypeQuestion')->find($request->get('type_question_id'));


        $thisUser = $em->getRepository('AppBundle:User')->find($request->get('user_id'));


        if (empty($contenu) || empty($typeQuestion) || empty($thisUser)) {
            return \FOS\RestBundle\View\View::create(['message' => 'entity not found'], Response::HTTP_NOT_FOUND);
        }

        $question = new Question();
        $question->setContenu($contenu)
                 ->setTypeQuestion($typeQuestion)
                 ->setUser($thisUser);

        $thisUser->addQuestion($question)  ;

        $form = $this->createForm(QuestionType::class, $question);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em->persist($question);
            $em->persist($thisUser);
            $em->flush();
            return $question;

        } else {
            return $form;
        }

    }

    /**
     * @Rest\View(serializerGroups={"reponse"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/lectureContenu/Question/{question_id}/{user_id}/Reponses")
     */
    public function postReponseAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $question = $em->getRepository('AppBundle:Question')->find($request->get('question_id'));

// Todo configurer plutard

        $thisUser = $em->getRepository('AppBundle:User')->find($request->get('user_id'));


        if (empty($question)) {
            return \FOS\RestBundle\View\View::create(['message' => 'Question concernant la réponse inexistante'], Response::HTTP_NOT_FOUND);
        }

        $reponse = new Reponse();
        $reponse->setQuestion($question)
                ->setUser($thisUser);

        $thisUser->addReponse($reponse)  ;

        $form = $this->createForm(ReponseType::class, $reponse);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em->persist($reponse);
            $em->persist($thisUser);
            $em->flush();
            return $reponse;

        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(serializerGroups={"commentaire"}, statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/lectureContenu/Question/Reponse/{reponse_id}/{user_id}/Commentaires")
     */
    public function postCommentaireAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $reponse = $em->getRepository('AppBundle:Reponse')->find($request->get('reponse_id'));
        $thisUser = $em->getRepository('AppBundle:User')->find($request->get('user_id'));


        if (empty($reponse) || empty($thisUser) ) {
            $this->entityNotFound();
        }

        $commentaire = new Commentaire();

        // Todo configurer parentId et depth plutard

        $commentaire->setReponse($reponse)
                    ->setParentId(1)
                    ->setDepth(1)
                    ->setUser($thisUser);

        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $em->persist($commentaire);
            $thisUser->addCommentaire($commentaire);
            $em->persist($thisUser);
            $em->flush();
            return $commentaire;

        } else {
            return $form;
        }
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/lectureContenu/Questions/{id}")
     */
    public function removeQuestionAction(Request $request)
    {
        $this->deleteEntity($request, "Question");
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/lectureContenu/Question/Reponses/{id}")
     */
    public function removeReponseAction(Request $request)
    {
        $this->deleteEntity($request, "Reponse");
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/lectureContenu/Question/Reponse/Commentaires/{id}")
     */
    public function removeCommentaireAction(Request $request)
    {
        $this->deleteEntity($request, "Commentaire");
    }


    private function deleteEntity(Request $request, $entityName)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("AppBundle:$entityName")->find($request->get('id'));

        $em->remove($entity);
        $em->flush();
    }

    /**
     * @Rest\View(serializerGroups={"contenu"})
     * @Rest\Patch("/lectureContenu/Questions/{id}")
     */
    public function patchQuestionAction(Request $request)
    {
        return $this->updateEntity($request, "Question");
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/lectureContenu/Question/Reponses/{id}")
     */
    public function patchReponseAction(Request $request)
    {
        return $this->updateEntity($request, "Reponse");
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * @Rest\Patch("/lectureContenu/Question/Reponse/Commentaires/{id}")
     */
    public function patchCommentaireAction(Request $request)
    {
        return $this->updateEntity($request, "Commentaire");
    }

    private function updateEntity(Request $request, $entityName)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository("AppBundle:$entityName")
            ->find($request->get('id'));

        if(strcmp($entityName,"Question")==0)
        {
            $entity->setNombreVu(1+$entity->getNombreVu());
        }

        $question = new Question();

        if(strlen($question->getLibelle())>10)
        {
            $entity->setDatePublication(new \DateTime());
        }

        if(empty($entity)) {
            return \FOS\RestBundle\View\View::create(["message" => "$entityName not found"], Response::HTTP_NOT_FOUND);
        }

        $entityType = QuestionType::class;
        if($entityName=="Reponse") $entityType = ReponseType::class;
        if($entityName=="Commentaire") $entityType = CommentaireType::class;

        $form = $this->createForm($entityType, $entity);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $entity;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/contenu/contenuRoot")
     */
    public function postCreateContenuRootAction(Request $request)
    {

        $uid = $_REQUEST['uid'];
        $filename = $_FILES['file']['name'];
        $upload_folder = 'media/';
        if (file_exists($upload_folder . $filename)) {
             $tab["fileAlreadyExist"] = true;
            return $tab;
        }

        if (empty($_FILES['file']['name'])) {
            return \FOS\RestBundle\View\View::create(['message' => 'Undefined file'], Response::HTTP_NOT_FOUND);
        }

        if (isset($_POST['_chunkNumber'])) {
            // the file is uploaded piece by piece, chunk mode
            $current_chunk_number = $_REQUEST['_chunkNumber'];
            $chunk_size = $_REQUEST['_chunkSize'];
            $total_size = $_REQUEST['_totalSize'];
            $upload_folder = 'media/';

            $total_chunk_number = ceil($total_size / $chunk_size);
            move_uploaded_file($_FILES['file']['tmp_name'], $upload_folder . $uid . '.part' . $current_chunk_number);
            // the last chunk of file has been received
            if ($current_chunk_number == ($total_chunk_number - 1)) {
                // reassemble the partial pieces to a whole file
                for ($i = 0; $i < $total_chunk_number; $i ++) {
                    $content = file_get_contents($upload_folder . $uid . '.part' . $i);
                    file_put_contents($upload_folder . $filename, $content, FILE_APPEND);
                    unlink($upload_folder . $uid . '.part' . $i);
                }

            }
            //return;
        } else {
            // the file is uploaded as a whole, no chunk mode

            move_uploaded_file($_FILES['file']['tmp_name'], $upload_folder.$filename);
        }

        $tab["contenuRoot"] = "http://localhost:8000/$upload_folder$filename";
        return $tab;

    }

    private function entityNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'entity not found'], Response::HTTP_NOT_FOUND);
    }

}
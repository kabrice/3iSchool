<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 17:37
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContenuController extends Controller
{
    /**
     * @Rest\View(serializerGroups={"contenu", "reponse"})
     * @Rest\Get("/lectureContenu/{id}")
     */
    public function getContenuLectureAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $contenu = $em->getRepository('AppBundle:Contenu')->find($request->get('id'));

        if (empty($contenu)) {
            return new JsonResponse(['message' => 'Contenu introuvable'], Response::HTTP_NOT_FOUND);
        }

        return $contenu;
    }
}
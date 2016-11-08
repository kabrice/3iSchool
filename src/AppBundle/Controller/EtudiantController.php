<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 10:52
 */

namespace AppBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EtudiantController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/etudiants/{id}")
     */
    public function getEtudiantAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $etudiant = $em->getRepository('AppBundle:Etudiant')->find($request->get('id'));

        if (empty($etudiant)) {
            return new JsonResponse(['message' => 'Etudiant introuvable'], Response::HTTP_NOT_FOUND);
        }

        $users = [
            'id' => $etudiant->getId(),
            'nom' => $etudiant->getNom(),
            'prenom' => $etudiant->getPrenom(),
            'email' => $etudiant->getEmail(),
            'dateCreation' => $etudiant->getDateCreation(),
        ];


        return $users;

    }

}
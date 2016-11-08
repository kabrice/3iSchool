<?php
/**
 * Created by IntelliJ IDEA.
 * User: Edgar
 * Date: 06/11/2016
 * Time: 11:27
 */

namespace AppBundle\Service;


use AppBundle\AppBundle;
use AppBundle\Entity\Enseignant;
use AppBundle\Entity\Etudiant;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class UserService
{


    /** @var  EntityManager */
    protected $entityManager;


    /**
     * DataChecker constructor.
     * @param EntityManager $entityManager
     *
     */
    public function __construct($entityManager)
    {
        $this->entityManager= $entityManager;
    }

    public function getAllUser(Request $request)
    {

        $users = [];

        $etudiants = $this->entityManager
                        ->getRepository('AppBundle:Etudiant')
                        ->findAll();
        $enseignants = $this->entityManager
            ->getRepository('AppBundle:Enseignant')
            ->findAll();



        foreach ($etudiants as $etudiant) {
            $users[] = [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'email' => $etudiant->getEmail(),
                'dateCreation' => $etudiant->getDateCreation(),
            ];
        }

        foreach ($enseignants as $enseignant) {
            $users[] = [
                'id' => $enseignant->getId(),
                'nom' => $enseignant->getNom(),
                'prenom' => $enseignant->getPrenom(),
                'email' => $enseignant->getEmail(),
                'dateCreation' => $enseignant->getDateCreation(),
            ];
        }



        return $users;
    }

}
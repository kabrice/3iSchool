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


        $allUser =[];
        $users = $this->entityManager
                        ->getRepository('AppBundle:User');




        foreach ($users as $user) {
            $allUser[] = [
                'id' => $user->getId(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'email' => $user->getEmail(),
                'dateCreation' => $user->getDateCreation(),
            ];
        }




        return $users;
    }

}
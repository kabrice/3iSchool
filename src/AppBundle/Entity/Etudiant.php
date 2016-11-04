<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtudiantRepository")
 */
class Etudiant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau", inversedBy="etudiants")
     * @var Niveau
     */
    protected $niveau;

    /**
     * @ORM\OneToMany(targetEntity="EtudiantGroupePromotion", mappedBy="etudiant")
     * @var EtudiantGroupePromotion[]
     */
    protected $etudiantGroupePromotions;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

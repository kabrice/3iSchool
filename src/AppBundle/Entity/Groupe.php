<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupeRepository")
 */
class Groupe
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", nullable=false, unique=true)
     */
    private $libelle;

    /**
     * @ManyToMany(targetEntity="Enseignant", inversedBy="groupes")
     */
    private $enseignants;

    /**
     * @ManyToMany(targetEntity="Rubrique", mappedBy="groupes")
     */
    private $rubriques;



    /**
     * @ORM\OneToMany(targetEntity="EtudiantGroupePromotion", mappedBy="groupe")
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

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Groupe
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}

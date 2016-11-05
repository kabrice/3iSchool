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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", nullable=false, unique=true)
     */
    protected $libelle;

    /**
     * @ManyToMany(targetEntity="Enseignant", inversedBy="groupes")
     */
    protected $enseignants;

    /**
     * @ManyToMany(targetEntity="Rubrique", mappedBy="groupes")
     */
    protected $rubriques;



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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enseignants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rubriques = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantGroupePromotions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add enseignant
     *
     * @param \AppBundle\Entity\Enseignant $enseignant
     *
     * @return Groupe
     */
    public function addEnseignant(\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants[] = $enseignant;

        return $this;
    }

    /**
     * Remove enseignant
     *
     * @param \AppBundle\Entity\Enseignant $enseignant
     */
    public function removeEnseignant(\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants->removeElement($enseignant);
    }

    /**
     * Get enseignants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnseignants()
    {
        return $this->enseignants;
    }

    /**
     * Add rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     *
     * @return Groupe
     */
    public function addRubrique(\AppBundle\Entity\Rubrique $rubrique)
    {
        $this->rubriques[] = $rubrique;

        return $this;
    }

    /**
     * Remove rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     */
    public function removeRubrique(\AppBundle\Entity\Rubrique $rubrique)
    {
        $this->rubriques->removeElement($rubrique);
    }

    /**
     * Get rubriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRubriques()
    {
        return $this->rubriques;
    }

    /**
     * Add etudiantGroupePromotion
     *
     * @param \AppBundle\Entity\EtudiantGroupePromotion $etudiantGroupePromotion
     *
     * @return Groupe
     */
    public function addEtudiantGroupePromotion(\AppBundle\Entity\EtudiantGroupePromotion $etudiantGroupePromotion)
    {
        $this->etudiantGroupePromotions[] = $etudiantGroupePromotion;

        return $this;
    }

    /**
     * Remove etudiantGroupePromotion
     *
     * @param \AppBundle\Entity\EtudiantGroupePromotion $etudiantGroupePromotion
     */
    public function removeEtudiantGroupePromotion(\AppBundle\Entity\EtudiantGroupePromotion $etudiantGroupePromotion)
    {
        $this->etudiantGroupePromotions->removeElement($etudiantGroupePromotion);
    }

    /**
     * Get etudiantGroupePromotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantGroupePromotions()
    {
        return $this->etudiantGroupePromotions;
    }
}

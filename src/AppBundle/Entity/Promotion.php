<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false, unique=true)
     */
    protected $libelle;

    /**
     * @ORM\OneToMany(targetEntity="EtudiantGroupePromotion", mappedBy="promotion")
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
     * @return Promotion
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
        $this->etudiantGroupePromotions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add etudiantGroupePromotion
     *
     * @param \AppBundle\Entity\EtudiantGroupePromotion $etudiantGroupePromotion
     *
     * @return Promotion
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

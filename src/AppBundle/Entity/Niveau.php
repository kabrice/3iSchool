<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NiveauRepository")
 */
class Niveau
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
     * @ORM\OneToMany(targetEntity="Conteneur", mappedBy="niveau")
     * @var Conteneur[]
     */
    protected $conteneurs;

    /**
     * @ORM\OneToMany(targetEntity="PromotionNotification", mappedBy="niveau")
     * @var PromotionNotification[]
     */
    protected $promotionNotifications;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conteneurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Niveau
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
     * Add conteneur
     *
     * @param \AppBundle\Entity\Conteneur $conteneur
     *
     * @return Niveau
     */
    public function addConteneur(\AppBundle\Entity\Conteneur $conteneur)
    {
        $this->conteneurs[] = $conteneur;

        return $this;
    }

    /**
     * Remove conteneur
     *
     * @param \AppBundle\Entity\Conteneur $conteneur
     */
    public function removeConteneur(\AppBundle\Entity\Conteneur $conteneur)
    {
        $this->conteneurs->removeElement($conteneur);
    }

    /**
     * Get conteneurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConteneurs()
    {
        return $this->conteneurs;
    }

    /**
     * Add promotionNotification
     *
     * @param \AppBundle\Entity\PromotionNotification $promotionNotification
     *
     * @return Niveau
     */
    public function addPromotionNotification(\AppBundle\Entity\PromotionNotification $promotionNotification)
    {
        $this->promotionNotifications[] = $promotionNotification;

        return $this;
    }

    /**
     * Remove promotionNotification
     *
     * @param \AppBundle\Entity\PromotionNotification $promotionNotification
     */
    public function removePromotionNotification(\AppBundle\Entity\PromotionNotification $promotionNotification)
    {
        $this->promotionNotifications->removeElement($promotionNotification);
    }

    /**
     * Get promotionNotifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotionNotifications()
    {
        return $this->promotionNotifications;
    }
}

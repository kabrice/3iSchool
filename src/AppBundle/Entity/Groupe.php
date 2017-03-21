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
     * @ORM\OneToMany(targetEntity="Conteneur", mappedBy="groupe")
     * @var Conteneur[]
     */
    protected $conteneurs;

    /**
     * @ORM\OneToMany(targetEntity="PromotionNotification", mappedBy="groupe")
     * @var PromotionNotification[]
     */
    protected $promotionNotifications;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="groupe")
     * @var Notification[]
     */
    protected $notifications;


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
     * Add conteneur
     *
     * @param \AppBundle\Entity\Conteneur $conteneur
     *
     * @return Groupe
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
     * @return Groupe
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

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Groupe
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \AppBundle\Entity\Notification $notification
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}

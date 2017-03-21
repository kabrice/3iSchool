<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromotionNotification
 *
 * @ORM\Table(name="promotion_notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionNotificationRepository")
 */
class PromotionNotification
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
     * @ORM\ManyToOne(targetEntity="Annee", inversedBy="promotionNotifications")
     * @var Annee
     */
    protected $annee;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="promotionNotifications")
     * @var Groupe
     */
    protected $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau", inversedBy="promotionNotifications")
     * @var Niveau
     */
    protected $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="promotionNotifications")
     * @var User
     */
    protected $user;


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
     * Set annee
     *
     * @param \AppBundle\Entity\Annee $annee
     *
     * @return PromotionNotification
     */
    public function setAnnee(\AppBundle\Entity\Annee $annee = null)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \AppBundle\Entity\Annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return PromotionNotification
     */
    public function setGroupe(\AppBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \AppBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set niveau
     *
     * @param \AppBundle\Entity\Niveau $niveau
     *
     * @return PromotionNotification
     */
    public function setNiveau(\AppBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \AppBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }


    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return PromotionNotification
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


}

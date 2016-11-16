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
     * @ORM\OneToMany(targetEntity="UserGroupePromotion", mappedBy="promotion")
     * @var UserGroupePromotion[]
     */
    protected $userGroupePromotions;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userGroupePromotions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add userGroupePromotion
     *
     * @param \AppBundle\Entity\UserGroupePromotion $userGroupePromotion
     *
     * @return Promotion
     */
    public function addUserGroupePromotion(\AppBundle\Entity\UserGroupePromotion $userGroupePromotion)
    {
        $this->userGroupePromotions[] = $userGroupePromotion;

        return $this;
    }

    /**
     * Remove userGroupePromotion
     *
     * @param \AppBundle\Entity\UserGroupePromotion $userGroupePromotion
     */
    public function removeUserGroupePromotion(\AppBundle\Entity\UserGroupePromotion $userGroupePromotion)
    {
        $this->userGroupePromotions->removeElement($userGroupePromotion);
    }

    /**
     * Get userGroupePromotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserGroupePromotions()
    {
        return $this->userGroupePromotions;
    }
}

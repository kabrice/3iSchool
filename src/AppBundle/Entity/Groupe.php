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
     * @ManyToMany(targetEntity="Rubrique", mappedBy="groupes")
     */
    protected $rubriques;



    /**
     * @ORM\OneToMany(targetEntity="UserGroupePromotion", mappedBy="groupe")
     * @var UserGroupePromotion[]
     */
    protected $userGroupePromotions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rubriques = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add userGroupePromotion
     *
     * @param \AppBundle\Entity\UserGroupePromotion $userGroupePromotion
     *
     * @return Groupe
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

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContenu
 *
 * @ORM\Table(name="user_contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserContenuRepository")
 */
class UserContenu
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
     * @var int
     *
     * @ORM\Column(name="nbre_vue", type="integer", nullable=false)
     */
    protected $nbreVue=1;

    /**
     * @var bool
     *
     * @ORM\Column(name="a_publie", type="boolean")
     */
    protected $aPublie;


    /**
     * @var string
     *
     * @ORM\Column(name="review", type="string", length=510, nullable=true)
     */
    protected $review;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userContenus")
     * @var User
     */
    protected $user;


    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="userContenus")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Contenu
     */
    protected $contenu;



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
     * Set nbreVue
     *
     * @param integer $nbreVue
     *
     * @return UserContenu
     */
    public function setNbreVue($nbreVue)
    {
        $this->nbreVue = $nbreVue;

        return $this;
    }

    /**
     * Get nbreVue
     *
     * @return integer
     */
    public function getNbreVue()
    {
        return $this->nbreVue;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserContenu
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

    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return UserContenu
     */
    public function setContenu(\AppBundle\Entity\Contenu $contenu = null)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return \AppBundle\Entity\Contenu
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set aPublie
     *
     * @param boolean $aPublie
     *
     * @return UserContenu
     */
    public function setAPublie($aPublie)
    {
        $this->aPublie = $aPublie;

        return $this;
    }

    /**
     * Get aPublie
     *
     * @return boolean
     */
    public function getAPublie()
    {
        return $this->aPublie;
    }

    /**
     * @return string
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * @param string $review
     */
    public function setReview($review)
    {
        $this->review = $review;
    }
    

}

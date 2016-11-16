<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string")
     */
    protected $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz")
     */
    protected $dateCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_bde", type="boolean")
     */
    protected $isBDE;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_enseignant", type="boolean")
     */
    protected $isEnseignant;


    /**
     * @ManyToMany(targetEntity="Commentaire", inversedBy="users")
     */
    protected $commentaires;

    /**
     * @ManyToMany(targetEntity="Reponse", inversedBy="users")
     */
    protected $reponses;

    /**
     * @ManyToMany(targetEntity="Question", inversedBy="users")
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="user")
     * @var UserContenu[]

     */
    protected $userContenus;

    /***Stop

    /**
     * @ORM\OneToMany(targetEntity="UserGroupePromotion", mappedBy="user")
     * @var UserGroupePromotion[]
     */
    protected $userGroupePromotions;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->userContenus = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return User
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set isBDE
     *
     * @param boolean $isBDE
     *
     * @return User
     */
    public function setIsBDE($isBDE)
    {
        $this->isBDE = $isBDE;

        return $this;
    }

    /**
     * Get isBDE
     *
     * @return boolean
     */
    public function getIsBDE()
    {
        return $this->isBDE;
    }

    /**
     * Set isEnseignant
     *
     * @param boolean $isEnseignant
     *
     * @return User
     */
    public function setIsEnseignant($isEnseignant)
    {
        $this->isEnseignant = $isEnseignant;

        return $this;
    }

    /**
     * Get isEnseignant
     *
     * @return boolean
     */
    public function getIsEnseignant()
    {
        return $this->isEnseignant;
    }

    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return User
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return User
     */
    public function addReponse(\AppBundle\Entity\Reponse $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     */
    public function removeReponse(\AppBundle\Entity\Reponse $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return User
     */
    public function addQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add userContenus
     *
     * @param \AppBundle\Entity\UserContenu $userContenus
     *
     * @return User
     */
    public function addUserContenus(\AppBundle\Entity\UserContenu $userContenus)
    {
        $this->userContenus[] = $userContenus;

        return $this;
    }

    /**
     * Remove userContenus
     *
     * @param \AppBundle\Entity\UserContenu $userContenus
     */
    public function removeUserContenus(\AppBundle\Entity\UserContenu $userContenus)
    {
        $this->userContenus->removeElement($userContenus);
    }

    /**
     * Get userContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserContenus()
    {
        return $this->userContenus;
    }
}

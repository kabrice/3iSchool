<?php

namespace AppBundle\Entity;

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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz")
     */
    private $dateCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="anonyme", type="boolean")
     */
    private $anonyme;

    /**
     * @var bool
     *
     * @ORM\Column(name="membre_bde", type="boolean")
     */
    private $membreBDE;

    /**
     * @ManyToMany(targetEntity="Commentaire", inversedBy="users")
     */
    private $commentaires;

    /**
     * @ManyToMany(targetEntity="Contribution", inversedBy="users")
     */
    private $contributions;

    /**
     * @ManyToMany(targetEntity="Question", inversedBy="users")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="user")
     * @var UserContenu[]

     */
    protected $userContenus;

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
     * Set anonyme
     *
     * @param boolean $anonyme
     *
     * @return User
     */
    public function setAnonyme($anonyme)
    {
        $this->anonyme = $anonyme;

        return $this;
    }

    /**
     * Get anonyme
     *
     * @return bool
     */
    public function getAnonyme()
    {
        return $this->anonyme;
    }

    /**
     * Set membreBDE
     *
     * @param boolean $membreBDE
     *
     * @return User
     */
    public function setMembreBDE($membreBDE)
    {
        $this->membreBDE = $membreBDE;

        return $this;
    }

    /**
     * Get membreBDE
     *
     * @return bool
     */
    public function getMembreBDE()
    {
        return $this->membreBDE;
    }
}

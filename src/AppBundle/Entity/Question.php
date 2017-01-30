<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="libelle", type="text")
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetimetz", nullable=false)
     */
    protected $datePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_like", type="integer")
     */
    protected $nombreLike=0;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_dislike", type="integer")
     */
    protected $nombreDislike=0;

    /**
     * @var int
     *
     * @ORM\Column(name="page", type="integer", nullable=true)
     */
    protected $page=0;

    /**
     * @var int
     *
     * @ORM\Column(name="ligne", type="integer", nullable=true)
     */
    protected $ligne=0;


    /**
     * @var bool
     *
     * @ORM\Column(name="anonyme", type="boolean")
     */
    protected $anonyme=0;

    /**
     * @var int
     *
     * @ORM\Column(name="report", type="integer")
     */
    protected $nbreInutile=0;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="questions")
     * @var Contenu
     */
    protected $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="TypeQuestion", inversedBy="questions")
     * @var TypeQuestion
     */
    protected $typeQuestion;

    /**
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="question", cascade={"persist", "remove", "merge"})
     * @var Reponse[]
     */
    protected $reponses;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="questions")
     * @var User
     */
    protected $user;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datePublication = new DateTime();
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userQuestions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Question
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
     * Set description
     *
     * @param string $description
     *
     * @return Question
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Question
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set nombreLike
     *
     * @param integer $nombreLike
     *
     * @return Question
     */
    public function setNombreLike($nombreLike)
    {
        $this->nombreLike = $nombreLike;

        return $this;
    }

    /**
     * Get nombreLike
     *
     * @return integer
     */
    public function getNombreLike()
    {
        return $this->nombreLike;
    }

    /**
     * Set nombreDislike
     *
     * @param integer $nombreDislike
     *
     * @return Question
     */
    public function setNombreDislike($nombreDislike)
    {
        $this->nombreDislike = $nombreDislike;

        return $this;
    }

    /**
     * Get nombreDislike
     *
     * @return integer
     */
    public function getNombreDislike()
    {
        return $this->nombreDislike;
    }

    /**
     * Set page
     *
     * @param integer $page
     *
     * @return Question
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set ligne
     *
     * @param integer $ligne
     *
     * @return Question
     */
    public function setLigne($ligne)
    {
        $this->ligne = $ligne;

        return $this;
    }

    /**
     * Get ligne
     *
     * @return integer
     */
    public function getLigne()
    {
        return $this->ligne;
    }


    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return Question
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
     * Set typeQuestion
     *
     * @param \AppBundle\Entity\TypeQuestion $typeQuestion
     *
     * @return Question
     */
    public function setTypeQuestion(\AppBundle\Entity\TypeQuestion $typeQuestion = null)
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }

    /**
     * Get typeQuestion
     *
     * @return \AppBundle\Entity\TypeQuestion
     */
    public function getTypeQuestion()
    {
        return $this->typeQuestion;
    }

    /**
     * Add reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return Question
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
     * Get userQuestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserQuestions()
    {
        return $this->userQuestions;
    }

    /**
     * Set anonyme
     *
     * @param boolean $anonyme
     *
     * @return Question
     */
    public function setAnonyme($anonyme)
    {
        $this->anonyme = $anonyme;

        return $this;
    }

    /**
     * Get anonyme
     *
     * @return boolean
     */
    public function getAnonyme()
    {
        return $this->anonyme;
    }

    /**
     * Set nbreInutile
     *
     * @param integer $nbreInutile
     *
     * @return Question
     */
    public function setNbreInutile($nbreInutile)
    {
        $this->nbreInutile = $nbreInutile;

        return $this;
    }

    /**
     * Get nbreInutile
     *
     * @return integer
     */
    public function getNbreInutile()
    {
        return $this->nbreInutile;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Question
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

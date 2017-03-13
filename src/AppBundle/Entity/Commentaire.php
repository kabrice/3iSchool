<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer")
     */
    protected $parent_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetimetz", nullable=false)
     */
    protected $datePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="depth", type="integer")
     */
    protected $depth;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_voted", type="boolean")
     */
    protected $hasVoted=0;


    /**
     * @var int
     *
     * @ORM\Column(name="nombre_like", type="integer")
     */
    protected $nombreLike=0;

    /**
     * @var bool
     *
     * @ORM\Column(name="anonyme", type="boolean")
     */
    protected $anonyme=0;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_inutile", type="integer")
     */
    protected $nbreInutile=0;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="commentaires")
     * @var Reponse
     */
    protected $reponse;



    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commentaires")
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="commentaire")
     * @var Notification[]
     */
    protected $notifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datePublication = new DateTime();
        $this->userCommentaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Commentaire
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
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Commentaire
     */
    public function setParentId($parentId)
    {
        $this->parent_id = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Commentaire
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
     * Set depth
     *
     * @param integer $depth
     *
     * @return Commentaire
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return integer
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set nombreLike
     *
     * @param integer $nombreLike
     *
     * @return Commentaire
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
     * Set reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return Commentaire
     */
    public function setReponse(\AppBundle\Entity\Reponse $reponse = null)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return \AppBundle\Entity\Reponse
     */
    public function getReponse()
    {
        return $this->reponse;
    }


    /**
     * Get userCommentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserCommentaires()
    {
        return $this->userCommentaires;
    }

    /**
     * Set anonyme
     *
     * @param boolean $anonyme
     *
     * @return Commentaire
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
     * @return Commentaire
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
     * @return Commentaire
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
     * Set hasVoted
     *
     * @param boolean $hasVoted
     *
     * @return Commentaire
     */
    public function setHasVoted($hasVoted)
    {
        $this->hasVoted = $hasVoted;

        return $this;
    }

    /**
     * Get hasVoted
     *
     * @return boolean
     */
    public function getHasVoted()
    {
        return $this->hasVoted;
    }
}

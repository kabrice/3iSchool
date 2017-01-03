<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

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
     * @var int
     *
     * @ORM\Column(name="nombre_like", type="integer")
     */
    protected $nombreLike=0;

    /**
     * @var int
     *
     * @ORM\Column(name="report", type="integer")
     */
    protected $report=0;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="commentaires")
     * @var Reponse
     */
    protected $reponse;



    /**
     * @ORM\OneToMany(targetEntity="UserCommentaire", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var UserCommentaire[]
     */
    protected $userCommentaires;



    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set report
     *
     * @param integer $report
     *
     * @return Commentaire
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return integer
     */
    public function getReport()
    {
        return $this->report;
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
     * Add userCommentaire
     *
     * @param \AppBundle\Entity\UserCommentaire $userCommentaire
     *
     * @return Commentaire
     */
    public function addUserCommentaire(\AppBundle\Entity\UserCommentaire $userCommentaire)
    {
        $this->userCommentaires[] = $userCommentaire;

        return $this;
    }

    /**
     * Remove userCommentaire
     *
     * @param \AppBundle\Entity\UserCommentaire $userCommentaire
     */
    public function removeUserCommentaire(\AppBundle\Entity\UserCommentaire $userCommentaire)
    {
        $this->userCommentaires->removeElement($userCommentaire);
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
}

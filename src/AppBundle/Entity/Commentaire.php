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
    protected $nombreLike;

    /**
     * @var bool
     *
     * @ORM\Column(name="report", type="boolean")
     */
    protected $report;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="commentaires")
     * @var Reponse
     */
    protected $reponse;

    /**
     * @ManyToMany(targetEntity="Enseignant", mappedBy="commentaires")
     */
    protected $enseignants;

    /**
     * @ManyToMany(targetEntity="Etudiant", mappedBy="commentaires")
     */
    protected $etudiants;


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
     * @return int
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
     * @return int
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
     * @return int
     */
    public function getNombreLike()
    {
        return $this->nombreLike;
    }

    /**
     * Set report
     *
     * @param boolean $report
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
     * @return bool
     */
    public function getReport()
    {
        return $this->report;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enseignants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add enseignant
     *
     * @param \AppBundle\Entity\Enseignant $enseignant
     *
     * @return Commentaire
     */
    public function addEnseignant(\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants[] = $enseignant;

        return $this;
    }

    /**
     * Remove enseignant
     *
     * @param \AppBundle\Entity\Enseignant $enseignant
     */
    public function removeEnseignant(\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants->removeElement($enseignant);
    }

    /**
     * Get enseignants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnseignants()
    {
        return $this->enseignants;
    }

    /**
     * Add etudiant
     *
     * @param \AppBundle\Entity\Etudiant $etudiant
     *
     * @return Commentaire
     */
    public function addEtudiant(\AppBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants[] = $etudiant;

        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \AppBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\AppBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants->removeElement($etudiant);
    }

    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiants()
    {
        return $this->etudiants;
    }
}

<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contenu
 *
 * @ORM\Table(name="contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContenuRepository")
 */
class Contenu
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false, unique=true)
     */
    protected $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="information", type="text", length=65535)
     */
    protected $information;

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
    protected $nombreLike;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_vue_total", type="integer")
     */
    protected $nombreVueTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_root", type="string", length=255, nullable=false)
     */
    protected $contenuRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="image_root", type="string", length=255, nullable=false)
     */
    protected $imageRoot;

    /**
     * @ORM\ManyToOne(targetEntity="Rubrique", inversedBy="contenus")
     * @var Rubrique
     */
    protected $rubrique;



    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="contenu")
     * @var Question[]
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="EnseignantContenu", mappedBy="contenu")
     * @var EnseignantContenu[]
     */
    protected $enseignantContenus;

    /**
     * @ORM\OneToMany(targetEntity="EtudiantContenu", mappedBy="contenu")
     * @var EtudiantContenu[]
     */
    protected $etudiantContenus;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datePublication = new DateTime();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enseignantContenus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiantContenus = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Contenu
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set information
     *
     * @param string $information
     *
     * @return Contenu
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information
     *
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Contenu
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
     * @return Contenu
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
     * Set nombreVueTotal
     *
     * @param integer $nombreVueTotal
     *
     * @return Contenu
     */
    public function setNombreVueTotal($nombreVueTotal)
    {
        $this->nombreVueTotal = $nombreVueTotal;

        return $this;
    }

    /**
     * Get nombreVueTotal
     *
     * @return integer
     */
    public function getNombreVueTotal()
    {
        return $this->nombreVueTotal;
    }

    /**
     * Set contenuRoot
     *
     * @param string $contenuRoot
     *
     * @return Contenu
     */
    public function setContenuRoot($contenuRoot)
    {
        $this->contenuRoot = $contenuRoot;

        return $this;
    }

    /**
     * Get contenuRoot
     *
     * @return string
     */
    public function getContenuRoot()
    {
        return $this->contenuRoot;
    }

    /**
     * Set imageRoot
     *
     * @param string $imageRoot
     *
     * @return Contenu
     */
    public function setImageRoot($imageRoot)
    {
        $this->imageRoot = $imageRoot;

        return $this;
    }

    /**
     * Get imageRoot
     *
     * @return string
     */
    public function getImageRoot()
    {
        return $this->imageRoot;
    }

    /**
     * Set rubrique
     *
     * @param \AppBundle\Entity\Rubrique $rubrique
     *
     * @return Contenu
     */
    public function setRubrique(\AppBundle\Entity\Rubrique $rubrique = null)
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    /**
     * Get rubrique
     *
     * @return \AppBundle\Entity\Rubrique
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Contenu
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
     * Add enseignantContenus
     *
     * @param \AppBundle\Entity\EnseignantContenu $enseignantContenus
     *
     * @return Contenu
     */
    public function addEnseignantContenus(\AppBundle\Entity\EnseignantContenu $enseignantContenus)
    {
        $this->enseignantContenus[] = $enseignantContenus;

        return $this;
    }

    /**
     * Remove enseignantContenus
     *
     * @param \AppBundle\Entity\EnseignantContenu $enseignantContenus
     */
    public function removeEnseignantContenus(\AppBundle\Entity\EnseignantContenu $enseignantContenus)
    {
        $this->enseignantContenus->removeElement($enseignantContenus);
    }

    /**
     * Get enseignantContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnseignantContenus()
    {
        return $this->enseignantContenus;
    }

    /**
     * Add etudiantContenus
     *
     * @param \AppBundle\Entity\EtudiantContenu $etudiantContenus
     *
     * @return Contenu
     */
    public function addEtudiantContenus(\AppBundle\Entity\EtudiantContenu $etudiantContenus)
    {
        $this->etudiantContenus[] = $etudiantContenus;

        return $this;
    }

    /**
     * Remove etudiantContenus
     *
     * @param \AppBundle\Entity\EtudiantContenu $etudiantContenus
     */
    public function removeEtudiantContenus(\AppBundle\Entity\EtudiantContenu $etudiantContenus)
    {
        $this->etudiantContenus->removeElement($etudiantContenus);
    }

    /**
     * Get etudiantContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantContenus()
    {
        return $this->etudiantContenus;
    }
}

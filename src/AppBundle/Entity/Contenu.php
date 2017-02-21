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
     * @ORM\Column(name="description", type="text", length=500)
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=false)
     */
    protected $datePublication;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    protected $note=0;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_vue_total", type="integer")
     */
    protected $nombreVueTotal=1;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_root", type="string", length=255, nullable=false)
     */
    protected $contenuRoot;


    /**
     * @var int
     *
     * @ORM\Column(name="nbre_noteur", type="integer")
     */
    protected $nbreNoteur=0;

    /**
     * @var string
     *
     * @ORM\Column(name="image_root", type="string", length=255, nullable=false)
     */
    protected $imageRoot;

    protected $imgB64;

    protected $listeGroupes;

    protected $listeNiveaux;

    /**
     * @ORM\ManyToOne(targetEntity="Rubrique", inversedBy="contenus", cascade={"persist", "merge"})
     * @var Rubrique
     */
    protected $rubrique;

    /**
     * @ORM\ManyToOne(targetEntity="SousRubrique", inversedBy="contenus", cascade={"persist", "merge"})
     * @var SousRubrique
     */
    protected $sousRubrique;



    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var Question[]
     */
    protected $questions;



    /**
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var UserContenu[]
     */
    protected $userContenus;

    /**
     * @ORM\OneToMany(targetEntity="VisiteContenu", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var VisiteContenu[]
     */
    protected $visiteContenus;


    /**
     * @ORM\OneToMany(targetEntity="Conteneur", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var Conteneur[]
     */
    protected $conteneurs;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datePublication = new DateTime();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userContenus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->conteneurs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Contenu
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = new \DateTime($datePublication);

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
     * Add userContenus
     *
     * @param \AppBundle\Entity\UserContenu $userContenus
     *
     * @return Contenu
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

    /**
     * Add conteneur
     *
     * @param \AppBundle\Entity\Conteneur $conteneur
     *
     * @return Contenu
     */
    public function addConteneur(\AppBundle\Entity\Conteneur $conteneur)
    {
        $this->conteneurs[] = $conteneur;

        return $this;
    }

    /**
     * Remove conteneur
     *
     * @param \AppBundle\Entity\Conteneur $conteneur
     */
    public function removeConteneur(\AppBundle\Entity\Conteneur $conteneur)
    {
        $this->conteneurs->removeElement($conteneur);
    }

    /**
     * Get conteneurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConteneurs()
    {
        return $this->conteneurs;
    }

    /**
     * Set sousRubrique
     *
     * @param \AppBundle\Entity\SousRubrique $sousRubrique
     *
     * @return Contenu
     */
    public function setSousRubrique(\AppBundle\Entity\SousRubrique $sousRubrique = null)
    {
        $this->sousRubrique = $sousRubrique;

        return $this;
    }

    /**
     * Get sousRubrique
     *
     * @return \AppBundle\Entity\SousRubrique
     */
    public function getSousRubrique()
    {
        return $this->sousRubrique;
    }




    /**
     * Set note
     *
     * @param float $note
     *
     * @return Contenu
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float
     */
    public function getNote()
    {
        return $this->note;
    }




    /**
     * Set nbreNoteur
     *
     * @param integer $nbreNoteur
     *
     * @return Contenu
     */
    public function setNbreNoteur($nbreNoteur)
    {
        $this->nbreNoteur = $nbreNoteur;

        return $this;
    }

    /**
     * Get nbreNoteur
     *
     * @return integer
     */
    public function getNbreNoteur()
    {
        return $this->nbreNoteur;
    }



    /**
     * Set description
     *
     * @param string $description
     *
     * @return Contenu
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
     * @return mixed
     */
    public function getImgB64()
    {
        return $this->imgB64;
    }

    /**
     * @param mixed $imgB64
     */
    public function setImgB64($imgB64)
    {
        $this->imgB64 = $imgB64;
    }

    /**
     * @return mixed
     */
    public function getListeGroupes()
    {
        return $this->listeGroupes;
    }

    /**
     * @param mixed $listeGroupes
     */
    public function setListeGroupes($listeGroupes)
    {
        $this->listeGroupes = $listeGroupes;
    }

    /**
     * @return mixed
     */
    public function getListeNiveaux()
    {
        return $this->listeNiveaux;
    }

    /**
     * @param mixed $listeNiveaux
     */
    public function setListeNiveaux($listeNiveaux)
    {
        $this->listeNiveaux = $listeNiveaux;
    }





    /**
     * Add visiteContenus
     *
     * @param \AppBundle\Entity\VisiteContenu $visiteContenus
     *
     * @return Contenu
     */
    public function addVisiteContenus(\AppBundle\Entity\VisiteContenu $visiteContenus)
    {
        $this->visiteContenus[] = $visiteContenus;

        return $this;
    }

    /**
     * Remove visiteContenus
     *
     * @param \AppBundle\Entity\VisiteContenu $visiteContenus
     */
    public function removeVisiteContenus(\AppBundle\Entity\VisiteContenu $visiteContenus)
    {
        $this->visiteContenus->removeElement($visiteContenus);
    }

    /**
     * Get visiteContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisiteContenus()
    {
        return $this->visiteContenus;
    }
}

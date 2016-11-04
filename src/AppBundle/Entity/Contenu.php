<?php

namespace AppBundle\Entity;

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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false, unique=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="information", type="text")
     */
    private $information;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetimetz", nullable=false)
     */
    private $datePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_like", type="integer")
     */
    private $nombreLike;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_vue_total", type="integer")
     */
    private $nombreVueTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_root", type="string", length=255, nullable=false)
     */
    private $contenuRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="image_root", type="string", length=255, nullable=false)
     */
    private $imageRoot;

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
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="contenu")
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
     * @return int
     */
    public function getNombreLike()
    {
        return $this->nombreLike;
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
}

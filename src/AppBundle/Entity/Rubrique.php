<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Rubrique
 *
 * @ORM\Table(name="rubrique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RubriqueRepository")
 */
class Rubrique
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
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="imageRoot", type="string", length=255)
     */
    private $imageRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="string", length=10000)
     */
    private $presentation;

    /**
     * @var string
     *
     * @ORM\Column(name="importance", type="text")
     */
    private $importance;


    /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="rubrique")
     * @var Contenu
     */
    protected $contenus;


    /**
     * @ORM\ManyToOne(targetEntity="TypeRubrique", inversedBy="rubriques")
     * @var TypeRubrique
     */
    protected $typeRubrique;

    /**
     * @ManyToMany(targetEntity="Groupe", inversedBy="rubriques")
     */
    private $groupes;

    /**
     * @ManyToMany(targetEntity="SousRubrique", mappedBy="rubriques")
     */
    private $sousRubriques;

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
     * @return Rubrique
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
     * Set imageRoot
     *
     * @param string $imageRoot
     *
     * @return Rubrique
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
     * Set presentation
     *
     * @param string $presentation
     *
     * @return Rubrique
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set importance
     *
     * @param string $importance
     *
     * @return Rubrique
     */
    public function setImportance($importance)
    {
        $this->importance = $importance;

        return $this;
    }

    /**
     * Get importance
     *
     * @return string
     */
    public function getImportance()
    {
        return $this->importance;
    }
}

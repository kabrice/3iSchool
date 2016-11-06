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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, unique=true)
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="imageRoot", type="string", length=255)
     */
    protected $imageRoot;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text")
     */
    protected $presentation;

    /**
     * @var string
     *
     * @ORM\Column(name="importance", type="text")
     */
    protected $importance;


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
    protected $groupes;

    /**
     * @ManyToMany(targetEntity="SousRubrique", mappedBy="rubriques")
     */
    protected $sousRubriques;

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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contenus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sousRubriques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contenus
     *
     * @param \AppBundle\Entity\Contenu $contenus
     *
     * @return Rubrique
     */
    public function addContenus(\AppBundle\Entity\Contenu $contenus)
    {
        $this->contenus[] = $contenus;

        return $this;
    }

    /**
     * Remove contenus
     *
     * @param \AppBundle\Entity\Contenu $contenus
     */
    public function removeContenus(\AppBundle\Entity\Contenu $contenus)
    {
        $this->contenus->removeElement($contenus);
    }

    /**
     * Get contenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContenus()
    {
        return $this->contenus;
    }

    /**
     * Set typeRubrique
     *
     * @param \AppBundle\Entity\TypeRubrique $typeRubrique
     *
     * @return Rubrique
     */
    public function setTypeRubrique(\AppBundle\Entity\TypeRubrique $typeRubrique = null)
    {
        $this->typeRubrique = $typeRubrique;

        return $this;
    }

    /**
     * Get typeRubrique
     *
     * @return \AppBundle\Entity\TypeRubrique
     */
    public function getTypeRubrique()
    {
        return $this->typeRubrique;
    }

    /**
     * Add groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return Rubrique
     */
    public function addGroupe(\AppBundle\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     */
    public function removeGroupe(\AppBundle\Entity\Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }

    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Add sousRubrique
     *
     * @param \AppBundle\Entity\SousRubrique $sousRubrique
     *
     * @return Rubrique
     */
    public function addSousRubrique(\AppBundle\Entity\SousRubrique $sousRubrique)
    {
        $this->sousRubriques[] = $sousRubrique;

        return $this;
    }

    /**
     * Remove sousRubrique
     *
     * @param \AppBundle\Entity\SousRubrique $sousRubrique
     */
    public function removeSousRubrique(\AppBundle\Entity\SousRubrique $sousRubrique)
    {
        $this->sousRubriques->removeElement($sousRubrique);
    }

    /**
     * Get sousRubriques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSousRubriques()
    {
        return $this->sousRubriques;
    }
}

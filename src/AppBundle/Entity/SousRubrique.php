<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * SousRubrique
 *
 * @ORM\Table(name="sous_rubrique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SousRubriqueRepository")
 */
class SousRubrique
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false, unique=true)
     */
    protected $libelle;

    /**
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="rubrique")
     * @ORM\OneToMany(targetEntity="Contenu", mappedBy="sousRubrique")
     * @var Contenu
     */
    protected $contenus;


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
     * @return SousRubrique
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
     * Constructor
     */
    public function __construct()
    {
        $this->contenus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contenus
     *
     * @param \AppBundle\Entity\Contenu $contenus
     *
     * @return SousRubrique
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
}

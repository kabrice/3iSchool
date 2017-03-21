<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conteneur
 *
 * @ORM\Table(name="conteneur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConteneurRepository")
 */
class Conteneur
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
     * @ORM\ManyToOne(targetEntity="Annee", inversedBy="conteneurs")
     * @var Annee
     */
    protected $annee;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="conteneurs")
     * @var Groupe
     */
    protected $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau", inversedBy="conteneurs")
     * @var Niveau
     */
    protected $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="conteneurs")
     * @var Contenu
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $contenu;


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
     * Set annee
     *
     * @param \AppBundle\Entity\Annee $annee
     *
     * @return Conteneur
     */
    public function setAnnee(\AppBundle\Entity\Annee $annee = null)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \AppBundle\Entity\Annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return Conteneur
     */
    public function setGroupe(\AppBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \AppBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set niveau
     *
     * @param \AppBundle\Entity\Niveau $niveau
     *
     * @return Conteneur
     */
    public function setNiveau(\AppBundle\Entity\Niveau $niveau = null)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \AppBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return Conteneur
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
}

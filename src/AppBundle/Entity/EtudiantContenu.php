<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantContenu
 *
 * @ORM\Table(name="etudiant_contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtudiantContenuRepository")
 */
class EtudiantContenu
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
     * @var int
     *
     * @ORM\Column(name="nbre_vue", type="integer", nullable=false)
     */
    private $nbreVue;

    /**
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="EtudiantContenus")
     * @var Etudiant
     */
    protected $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="EtudiantContenus")
     * @var Contenu
     */
    protected $contenu;


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
     * Set nbreVue
     *
     * @param integer $nbreVue
     *
     * @return EtudiantContenu
     */
    public function setNbreVue($nbreVue)
    {
        $this->nbreVue = $nbreVue;

        return $this;
    }

    /**
     * Get nbreVue
     *
     * @return int
     */
    public function getNbreVue()
    {
        return $this->nbreVue;
    }

    /**
     * Set etudiant
     *
     * @param \AppBundle\Entity\Etudiant $etudiant
     *
     * @return EtudiantContenu
     */
    public function setEtudiant(\AppBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \AppBundle\Entity\Etudiant
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return EtudiantContenu
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

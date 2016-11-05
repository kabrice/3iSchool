<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnseignantContenu
 *
 * @ORM\Table(name="enseignant_contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnseignantContenuRepository")
 */
class EnseignantContenu
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
     * @ORM\ManyToOne(targetEntity="Enseignant", inversedBy="EnseignantContenus")
     * @var Enseignant
     */
    protected $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="EnseignantContenus")
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
     * @return EnseignantContenu
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
     * Set enseignant
     *
     * @param \AppBundle\Entity\Enseignant $enseignant
     *
     * @return EnseignantContenu
     */
    public function setEnseignant(\AppBundle\Entity\Enseignant $enseignant = null)
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * Get enseignant
     *
     * @return \AppBundle\Entity\Enseignant
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return EnseignantContenu
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

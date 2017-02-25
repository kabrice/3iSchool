<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisiteContenu
 *
 * @ORM\Table(name="visite_contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisiteContenuRepository")
 */
class VisiteContenu
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_visite", type="datetimetz")
     */
    private $dateVisite;

    private $stringDate;

    /**
     * @var float
     *
     * @ORM\Column(name="duree", type="float")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="visiteContenus")
     * @var User
     */
    protected $user;


    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="visiteContenus")
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
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     *
     * @return VisiteContenu
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Set duree
     *
     * @param float $duree
     *
     * @return VisiteContenu
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return float
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return VisiteContenu
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set contenu
     *
     * @param \AppBundle\Entity\Contenu $contenu
     *
     * @return VisiteContenu
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

    /**
     * @return mixed
     */
    public function getStringDate()
    {
        return $this->stringDate;
    }

    /**
     * @param mixed $stringDate
     */
    public function setStringDate($stringDate)
    {
        $this->stringDate = $stringDate;
    }


}

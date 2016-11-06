<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtudiantRepository")
 */
class Etudiant
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
     * @ORM\ManyToOne(targetEntity="Niveau", inversedBy="etudiants")
     * @var Niveau
     */
    protected $niveau;
    

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz")
     */
    protected $dateCreation;


    /**
     * @var bool
     *
     * @ORM\Column(name="membre_bde", type="boolean")
     */
    protected $membreBDE;

    /**
     * @ManyToMany(targetEntity="Commentaire", inversedBy="etudiants")
     */
    protected $commentaires;

    /**
     * @ManyToMany(targetEntity="Contribution", inversedBy="etudiants")
     */
    protected $contributions;

    /**
     * @ManyToMany(targetEntity="Question", inversedBy="etudiants")
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="EtudiantContenu", mappedBy="etudiant")
     * @var EtudiantContenu[]

     */
    protected $EtudiantContenus;
    
    /***Stop

    /**
     * @ORM\OneToMany(targetEntity="EtudiantGroupePromotion", mappedBy="etudiant")
     * @var EtudiantGroupePromotion[]
     */
    protected $etudiantGroupePromotions;

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
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new DateTime();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contributions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->EtudiantContenus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Etudiant
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Etudiant
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Etudiant
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set anonyme
     *
     * @param boolean $anonyme
     *
     * @return Etudiant
     */
    public function setAnonyme($anonyme)
    {
        $this->anonyme = $anonyme;

        return $this;
    }

    /**
     * Get anonyme
     *
     * @return boolean
     */
    public function getAnonyme()
    {
        return $this->anonyme;
    }

    /**
     * Set membreBDE
     *
     * @param boolean $membreBDE
     *
     * @return Etudiant
     */
    public function setMembreBDE($membreBDE)
    {
        $this->membreBDE = $membreBDE;

        return $this;
    }

    /**
     * Get membreBDE
     *
     * @return boolean
     */
    public function getMembreBDE()
    {
        return $this->membreBDE;
    }

    /**
     * Set niveau
     *
     * @param \AppBundle\Entity\Niveau $niveau
     *
     * @return Etudiant
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
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Etudiant
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add contribution
     *
     * @param \AppBundle\Entity\Contribution $contribution
     *
     * @return Etudiant
     */
    public function addContribution(\AppBundle\Entity\Contribution $contribution)
    {
        $this->contributions[] = $contribution;

        return $this;
    }

    /**
     * Remove contribution
     *
     * @param \AppBundle\Entity\Contribution $contribution
     */
    public function removeContribution(\AppBundle\Entity\Contribution $contribution)
    {
        $this->contributions->removeElement($contribution);
    }

    /**
     * Get contributions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContributions()
    {
        return $this->contributions;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Etudiant
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
     * Add etudiantContenus
     *
     * @param \AppBundle\Entity\EtudiantContenu $etudiantContenus
     *
     * @return Etudiant
     */
    public function addEtudiantContenus(\AppBundle\Entity\EtudiantContenu $etudiantContenus)
    {
        $this->EtudiantContenus[] = $etudiantContenus;

        return $this;
    }

    /**
     * Remove etudiantContenus
     *
     * @param \AppBundle\Entity\EtudiantContenu $etudiantContenus
     */
    public function removeEtudiantContenus(\AppBundle\Entity\EtudiantContenu $etudiantContenus)
    {
        $this->EtudiantContenus->removeElement($etudiantContenus);
    }

    /**
     * Get etudiantContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiantContenus()
    {
        return $this->EtudiantContenus;
    }
}

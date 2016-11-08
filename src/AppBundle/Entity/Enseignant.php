<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Enseignant
 *
 * @ORM\Table(name="enseignant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnseignantRepository")
 */
class Enseignant
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
     * @ManyToMany(targetEntity="Commentaire", inversedBy="enseignants")
     */
    protected $commentaires;

    /**
     * @ManyToMany(targetEntity="Reponse", inversedBy="enseignants")
     */
    protected $reponses;

    /**
     * @ManyToMany(targetEntity="Question", inversedBy="enseignants")
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="EnseignantContenu", mappedBy="enseignant")
     * @var EnseignantContenu[]

     */
    protected $EnseignantContenus;



    /**
     * @ManyToMany(targetEntity="Groupe", mappedBy="enseignants")
     */
    protected $groupes;

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
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->EnseignantContenus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Enseignant
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
     * @return Enseignant
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
     * @return Enseignant
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
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Enseignant
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
     * Add reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return Enseignant
     */
    public function addReponse(\AppBundle\Entity\Reponse $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     */
    public function removeReponse(\AppBundle\Entity\Reponse $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Enseignant
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
     * Add enseignantContenus
     *
     * @param \AppBundle\Entity\EnseignantContenu $enseignantContenus
     *
     * @return Enseignant
     */
    public function addEnseignantContenus(\AppBundle\Entity\EnseignantContenu $enseignantContenus)
    {
        $this->EnseignantContenus[] = $enseignantContenus;

        return $this;
    }

    /**
     * Remove enseignantContenus
     *
     * @param \AppBundle\Entity\EnseignantContenu $enseignantContenus
     */
    public function removeEnseignantContenus(\AppBundle\Entity\EnseignantContenu $enseignantContenus)
    {
        $this->EnseignantContenus->removeElement($enseignantContenus);
    }

    /**
     * Get enseignantContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnseignantContenus()
    {
        return $this->EnseignantContenus;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Enseignant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return Enseignant
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
}
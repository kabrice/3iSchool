<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReponseRepository")
 */
class Reponse
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
     * @ORM\Column(name="libelle", type="text")
     */
    protected $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="type_reponse", type="string", length=1, options={"fixed" = true})
     */
    protected $typeReponse='N';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetimetz", nullable=false)
     */
    protected $datePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_like", type="integer")
     */
    protected $nombreLike=0;

    /**
     * @var int
     *
     * @ORM\Column(name="report", type="integer")
     */
    protected $report=0;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="reponses")
     * @var Question
     */
    protected $question;

    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="reponse", cascade={"persist", "remove", "merge"})
     * @var Commentaire[]
     */
    protected $commentaires;


    /**
     * @ORM\OneToMany(targetEntity="UserReponse", mappedBy="contenu", cascade={"persist", "remove", "merge"})
     * @var UserReponse[]
     */
    protected $userReponses;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userReponses = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Reponse
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
     * Set typeReponse
     *
     * @param string $typeReponse
     *
     * @return Reponse
     */
    public function setTypeReponse($typeReponse)
    {
        $this->typeReponse = $typeReponse;

        return $this;
    }

    /**
     * Get typeReponse
     *
     * @return string
     */
    public function getTypeReponse()
    {
        return $this->typeReponse;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Reponse
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
     * @return Reponse
     */
    public function setNombreLike($nombreLike)
    {
        $this->nombreLike = $nombreLike;

        return $this;
    }

    /**
     * Get nombreLike
     *
     * @return integer
     */
    public function getNombreLike()
    {
        return $this->nombreLike;
    }

    /**
     * Set report
     *
     * @param integer $report
     *
     * @return Reponse
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return integer
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Reponse
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Reponse
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
     * Add userReponse
     *
     * @param \AppBundle\Entity\UserReponse $userReponse
     *
     * @return Reponse
     */
    public function addUserReponse(\AppBundle\Entity\UserReponse $userReponse)
    {
        $this->userReponses[] = $userReponse;

        return $this;
    }

    /**
     * Remove userReponse
     *
     * @param \AppBundle\Entity\UserReponse $userReponse
     */
    public function removeUserReponse(\AppBundle\Entity\UserReponse $userReponse)
    {
        $this->userReponses->removeElement($userReponse);
    }

    /**
     * Get userReponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserReponses()
    {
        return $this->userReponses;
    }
}

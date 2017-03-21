<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="date_notification", type="datetime")
     */
    private $dateNotification;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=2)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Annee", inversedBy="notifications")
     * @var Annee
     */
    protected $annee;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau", inversedBy="notifications")
     * @var Niveau
     */
    protected $niveau;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="notifications")
     * @var Groupe
     */
    protected $groupe;
    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="notifications")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Contenu
     */
    protected $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="notifications")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Question
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="notifications")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Reponse
     */
    protected $reponse;

    /**
     * @ORM\ManyToOne(targetEntity="Commentaire", inversedBy="notifications", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Commentaire
     */
    protected $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="Inutile", inversedBy="notifications")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Inutile
     */
    protected $inutile;

    /**
     * @ORM\OneToMany(targetEntity="Notifier", mappedBy="notification")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var Notifier[]
     */
    protected $notifiers;
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
     * Set code
     *
     * @param string $code
     *
     * @return Notification
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateNotification = new DateTime();
        $this->notifiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Notification
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
     * @return Notification
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
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Notification
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
     * Set reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return Notification
     */
    public function setReponse(\AppBundle\Entity\Reponse $reponse = null)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return \AppBundle\Entity\Reponse
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Notification
     */
    public function setCommentaire(\AppBundle\Entity\Commentaire $commentaire = null)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return \AppBundle\Entity\Commentaire
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Add notifier
     *
     * @param \AppBundle\Entity\Notifier $notifier
     *
     * @return Notification
     */
    public function addNotifier(\AppBundle\Entity\Notifier $notifier)
    {
        $this->notifiers[] = $notifier;

        return $this;
    }

    /**
     * Remove notifier
     *
     * @param \AppBundle\Entity\Notifier $notifier
     */
    public function removeNotifier(\AppBundle\Entity\Notifier $notifier)
    {
        $this->notifiers->removeElement($notifier);
    }

    /**
     * Get notifiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifiers()
    {
        return $this->notifiers;
    }

    /**
     * Set annee
     *
     * @param \AppBundle\Entity\Annee $annee
     *
     * @return Notification
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
     * Set niveau
     *
     * @param \AppBundle\Entity\Niveau $niveau
     *
     * @return Notification
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
     * Set groupe
     *
     * @param \AppBundle\Entity\Groupe $groupe
     *
     * @return Notification
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
     * Set inutile
     *
     * @param \AppBundle\Entity\Inutile $inutile
     *
     * @return Notification
     */
    public function setInutile(\AppBundle\Entity\Inutile $inutile = null)
    {
        $this->inutile = $inutile;

        return $this;
    }

    /**
     * Get inutile
     *
     * @return \AppBundle\Entity\Inutile
     */
    public function getInutile()
    {
        return $this->inutile;
    }

    /**
     * Set dateNotification
     *
     * @param \DateTime $dateNotification
     *
     * @return Notification
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;

        return $this;
    }

    /**
     * Get dateNotification
     *
     * @return \DateTime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }
}

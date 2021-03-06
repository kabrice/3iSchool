<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="users_email_unique",columns={"email"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
    protected $nom="";


    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom="";

    /**
     * @var string
     *
     * @ORM\Column(name="user_profil_root", type="string", nullable=true)
     *
     */
    protected $userProfilRoot="";


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetimetz")
     */
    protected $dateCreation;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_bde", type="boolean")
     */
    protected $isBDE;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_personnel", type="boolean")
     */
    protected $isPersonnel;

    /**
     * @ORM\Column(type="string")
     */
    protected $password="";

    protected $plainPassword;

    protected $croppedDataUrl;

    protected $picFileName;

    protected $gRecaptchaResponse;

    /**
     * @ORM\Column(type="string")
     */
    protected $validationCode="";

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active=0;



    /**
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="user", cascade={"persist", "remove", "merge"})
     * @var Commentaire[]
     */
    protected $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="user", cascade={"persist", "remove", "merge"})
     * @var Reponse[]
     */
    protected $reponses;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="user", cascade={"persist", "remove", "merge"})
     * @var Question[]
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="user")
     * @var UserContenu[]
     */
    protected $userContenus;

    /**
     * @ORM\OneToMany(targetEntity="VisiteContenu", mappedBy="user")
     * @var VisiteContenu[]
     */
    protected $visiteContenus;

    /**
     * @ORM\OneToMany(targetEntity="PromotionNotification", mappedBy="user")
     * @var PromotionNotification[]
     */
    protected $promotionNotifications;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="user")
     * @var Notification[]
     */
    protected $notifications;

    /**
     * @ORM\OneToMany(targetEntity="Notifier", mappedBy="user")
     * @var Notifier[]
     */
    protected $notifiers;

    /**
     * Set isPersonnel
     *
     * @param boolean $isPersonnel
     *
     * @return User
     */
    public function setIsPersonnel($isPersonnel)
    {
        $this->isPersonnel = $isPersonnel;

        return $this;
    }


    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
      }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Set userProfilRoot
     *
     * @param string $userProfilRoot
     *
     * @return User
     */
    public function setUserProfilRoot($userProfilRoot)
    {
        $this->userProfilRoot = $userProfilRoot;

        return $this;
    }

    /**
     * Get userProfilRoot
     *
     * @return string
     */
    public function getUserProfilRoot()
    {
        return $this->userProfilRoot;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation  = new DateTime();
        $this->isBDE = false;
        $this->isPersonnel = false;
        $this->userCommentaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userReponses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userContenus = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Set isBDE
     *
     * @param boolean $isBDE
     *
     * @return User
     */
    public function setIsBDE($isBDE)
    {
        $this->isBDE = $isBDE;

        return $this;
    }

    /**
     * Get isBDE
     *
     * @return boolean
     */
    public function getIsBDE()
    {
        return $this->isBDE;
    }

    /**
     * Get isPersonnel
     *
     * @return boolean
     */
    public function getIsPersonnel()
    {
        return $this->isPersonnel;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set validationCode
     *
     * @param string $validationCode
     *
     * @return User
     */
    public function setValidationCode($validationCode)
    {
        $this->validationCode = $validationCode;

        return $this;
    }

    /**
     * Get validationCode
     *
     * @return string
     */
    public function getValidationCode()
    {
        return $this->validationCode;
    }



    /**
     * Add userContenus
     *
     * @param \AppBundle\Entity\UserContenu $userContenus
     *
     * @return User
     */
    public function addUserContenus(\AppBundle\Entity\UserContenu $userContenus)
    {
        $this->userContenus[] = $userContenus;

        return $this;
    }

    /**
     * Remove userContenus
     *
     * @param \AppBundle\Entity\UserContenu $userContenus
     */
    public function removeUserContenus(\AppBundle\Entity\UserContenu $userContenus)
    {
        $this->userContenus->removeElement($userContenus);
    }

    /**
     * Get userContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserContenus()
    {
        return $this->userContenus;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function getCroppedDataUrl()
    {
        return $this->croppedDataUrl;
    }

    /**
     * @param mixed $croppedDataUrl
     */
    public function setCroppedDataUrl($croppedDataUrl)
    {
        $this->croppedDataUrl = $croppedDataUrl;
    }

    /**
     * @return mixed
     */
    public function getPicFileName()
    {
        return $this->picFileName;
    }

    /**
     * @param mixed $picFileName
     */
    public function setPicFileName($picFileName)
    {
        $this->picFileName = $picFileName;
    }

    /**
     * @return mixed
     */
    public function getGRecaptchaResponse()
    {
        return $this->gRecaptchaResponse;
    }

    /**
     * @param mixed $gRecaptchaResponse
     */
    public function setGRecaptchaResponse($gRecaptchaResponse)
    {
        $this->gRecaptchaResponse = $gRecaptchaResponse;
    }



    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Add visiteContenus
     *
     * @param \AppBundle\Entity\VisiteContenu $visiteContenus
     *
     * @return User
     */
    public function addVisiteContenus(\AppBundle\Entity\VisiteContenu $visiteContenus)
    {
        $this->visiteContenus[] = $visiteContenus;

        return $this;
    }

    /**
     * Remove visiteContenus
     *
     * @param \AppBundle\Entity\VisiteContenu $visiteContenus
     */
    public function removeVisiteContenus(\AppBundle\Entity\VisiteContenu $visiteContenus)
    {
        $this->visiteContenus->removeElement($visiteContenus);
    }

    /**
     * Get visiteContenus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisiteContenus()
    {
        return $this->visiteContenus;
    }

    /**
     * Add promotionNotification
     *
     * @param \AppBundle\Entity\PromotionNotification $promotionNotification
     *
     * @return User
     */
    public function addPromotionNotification(\AppBundle\Entity\PromotionNotification $promotionNotification)
    {
        $this->promotionNotifications[] = $promotionNotification;

        return $this;
    }

    /**
     * Remove promotionNotification
     *
     * @param \AppBundle\Entity\PromotionNotification $promotionNotification
     */
    public function removePromotionNotification(\AppBundle\Entity\PromotionNotification $promotionNotification)
    {
        $this->promotionNotifications->removeElement($promotionNotification);
    }

    /**
     * Get promotionNotifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotionNotifications()
    {
        return $this->promotionNotifications;
    }

    /**
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return User
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \AppBundle\Entity\Notification $notification
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Add notifier
     *
     * @param \AppBundle\Entity\Notifier $notifier
     *
     * @return User
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
}

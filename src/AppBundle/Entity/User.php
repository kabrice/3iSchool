<?php

namespace AppBundle\Entity;

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
     * @ORM\Column(name="nom", type="string")
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string")
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_profil_root", type="string", nullable=true)
     */
    protected $userProfilRoot;

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
    protected $password;

    protected $plainPassword;

    /**
     * @ORM\Column(type="string")
     */
    protected $validationCode;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;



    /**
     * @ORM\OneToMany(targetEntity="UserCommentaire", mappedBy="user")
     * @var UserCommentaire[]
     */
    protected $userCommentaires;

    /**
     * @ORM\OneToMany(targetEntity="UserReponse", mappedBy="user")
     * @var UserReponse[]
     */
    protected $userReponses;

    /**
     * @ORM\OneToMany(targetEntity="UserQuestion", mappedBy="user")
     * @var UserQuestion[]
     */
    protected $userQuestions;

    /**
     * @ORM\OneToMany(targetEntity="UserContenu", mappedBy="user")
     * @var UserContenu[]
     */
    protected $userContenus;


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
     * }
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
     * Add userCommentaire
     *
     * @param \AppBundle\Entity\UserCommentaire $userCommentaire
     *
     * @return User
     */
    public function addUserCommentaire(\AppBundle\Entity\UserCommentaire $userCommentaire)
    {
        $this->userCommentaires[] = $userCommentaire;

        return $this;
    }

    /**
     * Remove userCommentaire
     *
     * @param \AppBundle\Entity\UserCommentaire $userCommentaire
     */
    public function removeUserCommentaire(\AppBundle\Entity\UserCommentaire $userCommentaire)
    {
        $this->userCommentaires->removeElement($userCommentaire);
    }

    /**
     * Get userCommentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserCommentaires()
    {
        return $this->userCommentaires;
    }

    /**
     * Add userReponse
     *
     * @param \AppBundle\Entity\UserReponse $userReponse
     *
     * @return User
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

    /**
     * Add userQuestion
     *
     * @param \AppBundle\Entity\UserQuestion $userQuestion
     *
     * @return User
     */
    public function addUserQuestion(\AppBundle\Entity\UserQuestion $userQuestion)
    {
        $this->userQuestions[] = $userQuestion;

        return $this;
    }

    /**
     * Remove userQuestion
     *
     * @param \AppBundle\Entity\UserQuestion $userQuestion
     */
    public function removeUserQuestion(\AppBundle\Entity\UserQuestion $userQuestion)
    {
        $this->userQuestions->removeElement($userQuestion);
    }

    /**
     * Get userQuestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserQuestions()
    {
        return $this->userQuestions;
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
}

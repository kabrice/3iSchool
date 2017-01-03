<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCommentaire
 *
 * @ORM\Table(name="user_commentaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserCommentaireRepository")
 */
class UserCommentaire
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
     * @var bool
     *
     * @ORM\Column(name="inutile", type="boolean")
     */
    protected $inutile;

    /**
     * @var bool
     *
     * @ORM\Column(name="anonyme", type="boolean")
     */
    protected $anonyme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_report", type="datetimetz")
     */
    protected $dateReport;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userCommentaires")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userCommentaires")
     * @var User
     */
    protected $userReporter;


    /**
     * @ORM\ManyToOne(targetEntity="Commentaire", inversedBy="userCommentaires")
     * @var Commentaire
     */
    protected $commentaire;


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
     * Set inutile
     *
     * @param boolean $inutile
     *
     * @return UserCommentaire
     */
    public function setInutile($inutile)
    {
        $this->inutile = $inutile;

        return $this;
    }

    /**
     * Get inutile
     *
     * @return bool
     */
    public function getInutile()
    {
        return $this->inutile;
    }

    /**
     * Set anonyme
     *
     * @param boolean $anonyme
     *
     * @return UserCommentaire
     */
    public function setAnonyme($anonyme)
    {
        $this->anonyme = $anonyme;

        return $this;
    }

    /**
     * Get anonyme
     *
     * @return bool
     */
    public function getAnonyme()
    {
        return $this->anonyme;
    }

    /**
     * Set dateReport
     *
     * @param \DateTime $dateReport
     *
     * @return UserCommentaire
     */
    public function setDateReport($dateReport)
    {
        $this->dateReport = $dateReport;

        return $this;
    }

    /**
     * Get dateReport
     *
     * @return \DateTime
     */
    public function getDateReport()
    {
        return $this->dateReport;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserCommentaire
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
     * Set userReporter
     *
     * @param \AppBundle\Entity\User $userReporter
     *
     * @return UserCommentaire
     */
    public function setUserReporter(\AppBundle\Entity\User $userReporter = null)
    {
        $this->userReporter = $userReporter;

        return $this;
    }

    /**
     * Get userReporter
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserReporter()
    {
        return $this->userReporter;
    }

    /**
     * Set commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return UserCommentaire
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
}

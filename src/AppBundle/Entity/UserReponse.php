<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserReponse
 *
 * @ORM\Table(name="user_reponse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserReponseRepository")
 */
class UserReponse
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userReponses")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userReponses")
     * @var User
     */
    protected $userReporter;


    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="userReponses")
     * @var Reponse
     */
    protected $reponse;



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
     * @return UserReponse
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
     * @return UserReponse
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
     * @return UserReponse
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
     * @return UserReponse
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
     * @return UserReponse
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
     * Set reponse
     *
     * @param \AppBundle\Entity\Reponse $reponse
     *
     * @return UserReponse
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
}

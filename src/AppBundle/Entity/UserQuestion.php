<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserQuestion
 *
 * @ORM\Table(name="user_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserQuestionRepository")
 */
class UserQuestion
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userQuestions")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userQuestions")
     * @var User
     */
    protected $userReporter;


    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="userQuestions")
     * @var Question
     */
    protected $question;



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
     * Set inutile
     *
     * @param boolean $inutile
     *
     * @return UserQuestion
     */
    public function setInutile($inutile)
    {
        $this->inutile = $inutile;

        return $this;
    }

    /**
     * Get inutile
     *
     * @return boolean
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
     * @return UserQuestion
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
     * Set dateReport
     *
     * @param \DateTime $dateReport
     *
     * @return UserQuestion
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
     * @return UserQuestion
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
     * @return UserQuestion
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
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return UserQuestion
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
}

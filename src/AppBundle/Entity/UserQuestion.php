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
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="inutile", type="bool")
     */
    private $inutile;

    /**
     * @var bool
     *
     * @ORM\Column(name="anonyme", type="bool")
     */
    private $anonyme;


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
     * @param \bool $inutile
     *
     * @return UserQuestion
     */
    public function setInutile(\bool $inutile)
    {
        $this->inutile = $inutile;

        return $this;
    }

    /**
     * Get inutile
     *
     * @return \bool
     */
    public function getInutile()
    {
        return $this->inutile;
    }

    /**
     * Set anonyme
     *
     * @param \bool $anonyme
     *
     * @return UserQuestion
     */
    public function setAnonyme(\bool $anonyme)
    {
        $this->anonyme = $anonyme;

        return $this;
    }

    /**
     * Get anonyme
     *
     * @return \bool
     */
    public function getAnonyme()
    {
        return $this->anonyme;
    }
}


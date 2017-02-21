<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $userID;

    /**
     * @var int
     *
     * @ORM\Column(name="ref_id", type="integer")
     */
    protected $refID;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255)
     */
    protected $ref;

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float")
     */
    protected $valeur;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_vote", type="datetimetz")
     */
    protected $dateVote;

    /**
     * Vote constructor.
     * @param int $id
     */
    public function __construct()
    {
        $this->dateVote = new \DateTime();
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
     * Set userID
     *
     * @param integer $userID
     *
     * @return Vote
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get userID
     *
     * @return integer
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Set refID
     *
     * @param integer $refID
     *
     * @return Vote
     */
    public function setRefID($refID)
    {
        $this->refID = $refID;

        return $this;
    }

    /**
     * Get refID
     *
     * @return integer
     */
    public function getRefID()
    {
        return $this->refID;
    }

    /**
     * Set ref
     *
     * @param string $ref
     *
     * @return Vote
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set dateVote
     *
     * @param \DateTime $dateVote
     *
     * @return Vote
     */
    public function setDateVote($dateVote)
    {
        $this->dateVote = $dateVote;

        return $this;
    }

    /**
     * Get dateVote
     *
     * @return \DateTime
     */
    public function getDateVote()
    {
        return $this->dateVote;
    }


    /**
     * Set valeur
     *
     * @param float $valeur
     *
     * @return Vote
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return float
     */
    public function getValeur()
    {
        return $this->valeur;
    }
}

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
     * @ORM\Column(name="num_ref", type="integer")
     */
    protected $num_ref;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255)
     */
    protected $ref;

    /**
     * @var int
     *
     * @ORM\Column(name="valeur", type="integer")
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
     * @param \DateTime $dateVote
     */
    public function __construct()
    {

        $this->dateVote = new \DateTime();
    }


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
     * Set numRef
     *
     * @param integer $numRef
     *
     * @return Vote
     */
    public function setNumRef($numRef)
    {
        $this->num_ref = $numRef;

        return $this;
    }

    /**
     * Get numRef
     *
     * @return int
     */
    public function getNumRef()
    {
        return $this->num_ref;
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
     * Set valeur
     *
     * @param integer $valeur
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
     * @return int
     */
    public function getValeur()
    {
        return $this->valeur;
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
}

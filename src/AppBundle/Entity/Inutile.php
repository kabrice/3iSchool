<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Inutile
 *
 * @ORM\Table(name="inutile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InutileRepository")
 */
class Inutile
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userID;

    /**
     * @var int
     *
     * @ORM\Column(name="ref_id", type="integer")
     */
    private $refID;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=255, nullable=false)
     */
    private $ref;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inutile", type="datetimetz")
     */
    private $dateInutile;

    /**
     * Inutile constructor.
     * @param \DateTime $dateInutile
     */
    public function __construct()
    {
        $this->dateInutile =  new DateTime();
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
     * @return Inutile
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
     * @return Inutile
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
     * @return Inutile
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
     * Set dateInutile
     *
     * @param \DateTime $dateInutile
     *
     * @return Inutile
     */
    public function setDateInutile($dateInutile)
    {
        $this->dateInutile = $dateInutile;

        return $this;
    }

    /**
     * Get dateInutile
     *
     * @return \DateTime
     */
    public function getDateInutile()
    {
        return $this->dateInutile;
    }
}

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
     * @ORM\Column(name="num_ref", type="integer")
     */
    private $numRef;

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
    public function __construct(\DateTime $dateInutile)
    {
        $this->dateInutile =  new DateTime();
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
     * @return Inutile
     */
    public function setNumRef($numRef)
    {
        $this->numRef = $numRef;

        return $this;
    }

    /**
     * Get numRef
     *
     * @return int
     */
    public function getNumRef()
    {
        return $this->numRef;
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

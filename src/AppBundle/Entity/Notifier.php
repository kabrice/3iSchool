<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifier
 *
 * @ORM\Table(name="notifier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotifierRepository")
 */
class Notifier
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
     * @ORM\Column(name="lu", type="boolean")
     */
    private $lu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lu", type="datetime")
     */
    private $dateLu;

    /**
     * @var bool
     *
     * @ORM\Column(name="vu", type="boolean")
     */
    private $vu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_vu", type="datetime")
     */
    private $dateVu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_notifier", type="datetime")
     */
    private $dateNotifier;

    /**
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="notifiers")
     * @var Notification
     */
    protected $notification;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifiers")
     * @var User
     */
    protected $user;

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
     * Set lu
     *
     * @param boolean $lu
     *
     * @return Notifier
     */
    public function setLu($lu)
    {
        $this->lu = $lu;

        return $this;
    }

    /**
     * Get lu
     *
     * @return bool
     */
    public function getLu()
    {
        return $this->lu;
    }

    /**
     * Set dateLu
     *
     * @param \DateTime $dateLu
     *
     * @return Notifier
     */
    public function setDateLu($dateLu)
    {
        $this->dateLu = $dateLu;

        return $this;
    }

    /**
     * Get dateLu
     *
     * @return \DateTime
     */
    public function getDateLu()
    {
        return $this->dateLu;
    }

    /**
     * Set vu
     *
     * @param boolean $vu
     *
     * @return Notifier
     */
    public function setVu($vu)
    {
        $this->vu = $vu;

        return $this;
    }

    /**
     * Get vu
     *
     * @return bool
     */
    public function getVu()
    {
        return $this->vu;
    }

    /**
     * Set dateVu
     *
     * @param \DateTime $dateVu
     *
     * @return Notifier
     */
    public function setDateVu($dateVu)
    {
        $this->dateVu = $dateVu;

        return $this;
    }

    /**
     * Get dateVu
     *
     * @return \DateTime
     */
    public function getDateVu()
    {
        return $this->dateVu;
    }

    /**
     * Set dateNotifier
     *
     * @param \DateTime $dateNotifier
     *
     * @return Notifier
     */
    public function setDateNotifier($dateNotifier)
    {
        $this->dateNotifier = $dateNotifier;

        return $this;
    }

    /**
     * Get dateNotifier
     *
     * @return \DateTime
     */
    public function getDateNotifier()
    {
        return $this->dateNotifier;
    }
}

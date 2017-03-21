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
    private $lu=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_lu", type="datetime", nullable=true)
     */
    private $dateLu;

    /**
     * @var bool
     *
     * @ORM\Column(name="vu", type="boolean")
     */
    private $vu=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_vu", type="datetime", nullable=true)
     */
    private $dateVu;


    /**
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="notifiers")
     * @ORM\JoinColumn(onDelete="CASCADE")
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
     * Set notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Notifier
     */
    public function setNotification(\AppBundle\Entity\Notification $notification = null)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return \AppBundle\Entity\Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Notifier
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
}

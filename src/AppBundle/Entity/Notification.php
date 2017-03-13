<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=1)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notifications")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="PromotionNotification", inversedBy="notifications")
     * @var PromotionNotification
     */
    protected $promotionNotification;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="notifications")
     * @var Contenu
     */
    protected $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="notifications")
     * @var Question
     */
    protected $question;

    /**
     * @ORM\ManyToOne(targetEntity="Reponse", inversedBy="notifications")
     * @var Reponse
     */
    protected $reponse;

    /**
     * @ORM\ManyToOne(targetEntity="Commentaire", inversedBy="notifications")
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
     * Set code
     *
     * @param string $code
     *
     * @return Notification
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}

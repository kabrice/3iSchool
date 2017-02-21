<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 * Entity for uploading images
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="image_root", type="string", length=1024, nullable=false)
     */
    protected $imageRoot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upload", type="datetimetz", nullable=false)
     */
    protected $dateUpload;


    protected $name;

    protected $imgB64;

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
     * Set userID
     *
     * @param integer $userID
     *
     * @return Image
     */
    public function setUserID($userID)
    {
        $this->dateUpload = new DateTime();
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get userID
     *
     * @return int
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Set imageRoot
     *
     * @param string $imageRoot
     *
     * @return Image
     */
    public function setImageRoot($imageRoot)
    {
        $this->imageRoot = $imageRoot;

        return $this;
    }

    /**
     * Get imageRoot
     *
     * @return string
     */
    public function getImageRoot()
    {
        return $this->imageRoot;
    }

    /**
     * Set dateUpload
     *
     * @param \DateTime $dateUpload
     *
     * @return Image
     */
    public function setDateUpload($dateUpload)
    {
        $this->dateUpload = $dateUpload;

        return $this;
    }

    /**
     * Get dateUpload
     *
     * @return \DateTime
     */
    public function getDateUpload()
    {
        return $this->dateUpload;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getImgB64()
    {
        return $this->imgB64;
    }

    /**
     * @param mixed $imgB64
     */
    public function setImgB64($imgB64)
    {
        $this->imgB64 = $imgB64;
    }


}

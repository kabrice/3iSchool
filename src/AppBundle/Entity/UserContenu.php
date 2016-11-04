<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContenu
 *
 * @ORM\Table(name="user_contenu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserContenuRepository")
 */
class UserContenu
{

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_vue", type="integer")
     */
    private $nbreVue;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userContenus")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Contenu", inversedBy="userContenus")
     * @var Contenu
     */
    protected $contenu;

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
     * Set nbreVue
     *
     * @param integer $nbreVue
     *
     * @return UserContenu
     */
    public function setNbreVue($nbreVue)
    {
        $this->nbreVue = $nbreVue;

        return $this;
    }

    /**
     * Get nbreVue
     *
     * @return int
     */
    public function getNbreVue()
    {
        return $this->nbreVue;
    }
}


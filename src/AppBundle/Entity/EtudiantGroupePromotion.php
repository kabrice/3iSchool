<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtudiantGroupePromotion
 *
 * @ORM\Table(name="etudiant_groupe_promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EtudiantGroupePromotionRepository")
 */
class EtudiantGroupePromotion
{

    /**
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="enseignantGroupePromotion")
     * @var Promotion
     */
    protected $promotion;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe", inversedBy="enseignantGroupePromotion")
     * @var Groupe
     */
    protected $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="enseignantGroupePromotion")
     * @var Etudiant
     */
    protected $etudiant;
}


<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Entity
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Ecole $ecole
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="formations", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_ecole", referencedColumnName="id")
     */
    private $ecole;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var ArrayCollection $promotions
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="formation", cascade={"persist", "remove", "merge"})
     */
    private $promotions;

    public function __construct() {
        $this->promotions = new ArrayCollection();
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
     * Set ecole
     *
     * @param Ecole $ecole
     *
     * @return Formation
     */
    public function setEcole(Ecole $ecole)
    {
        $this->ecole = $ecole;
    }

    /**
     * Get ecole
     *
     * @return Ecole
     */
    public function getEcole()
    {
        return $this->ecole;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Formation
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add promotion
     *
     * @param Promotion $promotion
     *
     * @return Formation
     */
    public function addPromotion(Promotion $promotion)
    {
        $promotion->setFormation($this);

        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
        }

        return $this;
    }

    /**
     * Set promotions
     *
     * @param ArrayCollection $promotions
     *
     * @return Formation
     */
    public function setPromotions(ArrayCollection $promotions)
    {
        $this->promotions = $promotions;

        return $this;
    }

    /**
     * Get promotions
     *
     * @return ArrayCollection $promotions
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}
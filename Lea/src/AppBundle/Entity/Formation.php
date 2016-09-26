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
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="formations", cascade={"remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $ecole;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="formation", cascade={"remove", "persist"})
     */
    private $promotions;


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
     * Add promotions
     *
     * @param Promotion $promotions
     *
     * @return Formation
     */
    public function addPromotion(Promotion $promotions)
    {
        $this->promotions[] = $promotions;

        return $this;
    }

    /**
     * Set promotions
     *
     * @param Collection $promotions
     *
     * @return Formation
     */
    public function setPromotions(Collection $promotions)
    {
        $this->promotions = $promotions;

        return $this;
    }

    /**
     * Get promotions
     *
     * @return Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}
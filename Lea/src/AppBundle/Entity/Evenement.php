<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Entity
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var bool
     * @ORM\Column(name="periode", type="boolean")
     */
    private $periode;

    /**
    * @ORM\OneToMany(targetEntity="Planning", mappedBy="evenement", cascade={"remove", "persist"})
    */
    private $plannings;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set periode
     *
     * @param boolean $periode
     *
     * @return Evenement
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;

        return $this;
    }

    /**
     * Get periode
     *
     * @return bool
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * Add plannings
     *
     * @param Planning $plannings
     *
     * @return Evenement
     */
    public function addPlanning(Planning $plannings)
    {
        $this->plannings[] = $plannings;

        return $this;
    }

    /**
     * Set plannings
     *
     * @param Collection $plannings
     *
     * @return Evenement
     */
    public function setPlannings(Collection $plannings)
    {
        $this->plannings = $plannings;

        return $this;
    }

    /**
     * Get plannings
     *
     * @return Collection
     */
    public function getPlannings()
    {
        return $this->plannings;
    }
}
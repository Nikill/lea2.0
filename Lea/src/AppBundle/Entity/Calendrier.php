<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calendrier
 *
 * @ORM\Entity
 * @ORM\Table(name="calendrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CalendrierRepository")
 */
class Calendrier
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Planning", mappedBy="calendrier", cascade={"remove", "persist"})
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
     * Add plannings
     *
     * @param Planning $plannings
     *
     * @return Calendrier
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
     * @return Calendrier
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
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
     * @var ArrayCollection $plannings
     * @ORM\OneToMany(targetEntity="Planning", mappedBy="calendrier", cascade={"persist", "remove", "merge"})
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
     * Add planning
     *
     * @param Planning $planning
     *
     * @return Calendrier
     */
    public function addPlanning(Planning $planning)
    {
        $planning->setCalendrier($this);

        if (!$this->plannings->contains($planning)) {
            $this->plannings->add($planning);
        }

        return $this;
    }

    /**
     * Set plannings
     *
     * @param ArrayCollection $plannings
     *
     * @return Calendrier
     */
    public function setPlannings(ArrayCollection $plannings)
    {
        $this->plannings = $plannings;

        return $this;
    }

    /**
     * Get plannings
     *
     * @return ArrayCollection
     */
    public function getPlannings()
    {
        return $this->plannings;
    }
}
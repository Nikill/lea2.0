<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Entity
 * @ORM\Table(name="planning")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="plannings", cascade={"remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $evenement;

    /**
     * @ORM\ManyToOne(targetEntity="Calendrier", inversedBy="plannings", cascade={"remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $calendrier;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_debut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fin", type="datetime")
     */
    private $dateFin;

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
     * Set evenement
     *
     * @param Evenement $evenement
     *
     * @return Planning
     */
    public function setEvenement(Evenement $evenement)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * Set calendrier
     *
     * @param Calendrier $calendrier
     *
     * @return Planning
     */
    public function setCalendrier(Calendrier $calendrier)
    {
        $this->calendrier = $calendrier;

        return $this;
    }

    /**
     * Get calendrier
     *
     * @return Calendrier
     */
    public function getCalendrier()
    {
        return $this->calendrier;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Planning
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Planning
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
}
<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Entity
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Formation $formation
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="promotions", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_formation", referencedColumnName="id")
     */
    private $formation;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="annee_debut", type="string", length=4)
     */
    private $anneeDebut;

    /**
     * @var string
     * @ORM\Column(name="annee_fin", type="string", length=4)
     */
    private $anneeFin;

    /**
     * @var Calendrier
     * @ORM\OneToOne(targetEntity="Calendrier", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="id_calendrier", referencedColumnName="id")
     */
    private $calendrier;

    /**
     * @var ArrayCollection $questionnaires
     * Owning Side
     * @ORM\ManyToMany(targetEntity="Questionnaire", inversedBy="promotions", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="promotion_questionnaires", joinColumns={@ORM\JoinColumn(name="id_promotion", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="id_questionnaire", referencedColumnName="id")})
     */
    private $questionnaires;

    /**
     * @var ArrayCollection $contrats
     * @ORM\OneToMany(targetEntity="Contrat", mappedBy="promotion", cascade={"persist", "remove", "merge"})
     */
    private $contrats;

    public function __construct() {
        $this->questionnaires = new ArrayCollection();
    }

    function __toString()
    {
        return $this->nom;
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
     * Set formation
     *
     * @param Formation $formation
     *
     * @return Promotion
     */
    public function setFormation(Formation $formation)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Promotion
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
     * Set anneeDebut
     *
     * @param string $anneeDebut
     *
     * @return Promotion
     */
    public function setAnneeDebut($anneeDebut)
    {
        $this->anneeDebut = $anneeDebut;

        return $this;
    }

    /**
     * Get anneeDebut
     *
     * @return string
     */
    public function getAnneeDebut()
    {
        return $this->anneeDebut;
    }

    /**
     * Set anneeFin
     *
     * @param string $anneeFin
     *
     * @return Promotion
     */
    public function setAnneeFin($anneeFin)
    {
        $this->anneeFin = $anneeFin;

        return $this;
    }

    /**
     * Get anneeFin
     *
     * @return string
     */
    public function getAnneeFin()
    {
        return $this->anneeFin;
    }

    /**
     * Set calendrier
     *
     * @param Calendrier $calendrier
     *
     * @return Promotion
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
     * Add questionnaire
     *
     * @param Questionnaire $questionnaire
     *
     * @return Promotion
     */
    public function addQuestionnaire(Questionnaire $questionnaire)
    {
        $questionnaire->addPromotion($this);

        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires->add($questionnaire);
        }

        return $this;
    }

    /**
     * Set questionnaires
     *
     * @param ArrayCollection $questionnaires
     *
     * @return Promotion
     */
    public function setQuestionnaires(ArrayCollection $questionnaires)
    {
        $this->questionnaires = $questionnaires;

        return $this;
    }

    /**
     * Get questionnaires
     *
     * @return ArrayCollection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Add contrat
     *
     * @param Contrat $contrat
     *
     * @return Promotion
     */
    public function addContrat(Contrat $contrat)
    {
        $contrat->setPromotion($this);

        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
        }

        return $this;
    }

    /**
     * Set contrats
     *
     * @param ArrayCollection $contrats
     *
     * @return Promotion
     */
    public function setContrats(ArrayCollection $contrats)
    {
        $this->contrats = $contrats;

        return $this;
    }

    /**
     * Get contrats
     *
     * @return ArrayCollection $contrats
     */
    public function getContrats()
    {
        return $this->contrats;
    }
}
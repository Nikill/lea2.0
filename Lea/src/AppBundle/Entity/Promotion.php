<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="promotions", cascade={"remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
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
     * @ORM\OneToOne(targetEntity="Calendrier")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $calendrier;

    /**
     * @ORM\ManyToMany(targetEntity="Questionnaire", mappedBy="promotions")
     */
    private $questionnaires;


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
     * Add questionnaires
     *
     * @param Questionnaire $questionnaires
     *
     * @return Promotion
     */
    public function addQuestionnaire(Questionnaire $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Set questionnaires
     *
     * @param Collection $questionnaires
     *
     * @return Promotion
     */
    public function setQuestionnaires(Collection $questionnaires)
    {
        $this->questionnaires = $questionnaires;

        return $this;
    }

    /**
     * Get questionnaires
     *
     * @return Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }
}
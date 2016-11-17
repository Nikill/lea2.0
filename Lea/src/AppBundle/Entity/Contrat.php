<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Entity
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User $etudiant
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_etudiant", referencedColumnName="id")
     */
    private $etudiant;

    /**
     * @var User $tuteur
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_tuteur", referencedColumnName="id")
     */
    private $tuteur;

    /**
     * @var User $map
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_map", referencedColumnName="id")
     */
    private $map;

    /**
     * @var Promotion $promotion
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="contrats", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_promotion", referencedColumnName="id")
     */
    private $promotion;

    /**
     * @var Entreprise $entreprise
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="contrats", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_entreprise", referencedColumnName="id")
     */
    private $entreprise;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_debut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fin", type="date")
     */
    private $dateFin;

    /**
     * @var ArrayCollection $questionnaires_individualises
     * @ORM\OneToMany(targetEntity="Questionnaire_Individualise", mappedBy="contrat", cascade={"persist", "remove", "merge"})
     */
    private $questionnaires_individualises;

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
     * Set etudiant
     *
     * @param User $etudiant
     *
     * @return Contrat
     */
    public function setEtudiant($etudiant)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return User
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set tuteur
     *
     * @param User $tuteur
     *
     * @return Contrat
     */
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;

        return $this;
    }

    /**
     * Get tuteur
     *
     * @return User
     */
    public function getTuteur()
    {
        return $this->tuteur;
    }

    /**
     * Set map
     *
     * @param User $map
     *
     * @return Contrat
     */
    public function setMap($map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return User
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set promotion
     *
     * @param Promotion $promotion
     *
     * @return Contrat
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->idPromotion;
    }

    /**
     * Set entreprise
     *
     * @param Entreprise $entreprise
     *
     * @return Contrat
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Contrat
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
     * @return Contrat
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

    /**
     * Add questionnaire_individualise
     *
     * @param Questionnaire_Individualise $questionnaire_individualise
     *
     * @return Contrat
     */
    public function addQuestionnaire_individualise(Questionnaire_Individualise $questionnaire_individualise)
    {
        $questionnaire_individualise->setContrat($this);

        if (!$this->questionnaires_individualises->contains($questionnaire_individualise)) {
            $this->questionnaires_individualises->add($questionnaire_individualise);
        }

        return $this;
    }

    /**
     * Set questionnaires_individualises
     *
     * @param ArrayCollection $questionnaires_individualises
     *
     * @return Contrat
     */
    public function setQuestionnaires_individualises(ArrayCollection $questionnaires_individualises)
    {
        $this->questionnaires_individualises = $questionnaires_individualises;

        return $this;
    }

    /**
     * Get questionnaires_individualises
     *
     * @return ArrayCollection $questionnaires_individualises
     */
    public function getQuestionnaires_individualises()
    {
        return $this->questionnaires_individualises;
    }
}
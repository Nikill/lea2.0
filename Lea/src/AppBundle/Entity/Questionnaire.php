<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire
 *
 * @ORM\Entity
 * @ORM\Table(name="questionnaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionnaireRepository")
 */
class Questionnaire
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection $promotions
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="Promotion", mappedBy="questionnaires", cascade={"persist", "merge"})
     */
    private $promotions;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_ouverture", type="date", nullable=true)
     */
    private $dateOuverture;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fermeture", type="date", nullable=true)
     */
    private $dateFermeture;

    /**
     * @var ArrayCollection $questions
     * Owning Side
     * @ORM\ManyToMany(targetEntity="Question", inversedBy="questionnaires", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="questionnaire_questions", joinColumns={@ORM\JoinColumn(name="id_questionnaire", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="id_question", referencedColumnName="id")})
     */
    private $questions;

    public function __construct() {
        $this->promotions = new ArrayCollection();
        $this->questions = new ArrayCollection();
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
     * Add promotion
     *
     * @param Promotion $promotion
     *
     * @return Questionnaire
     */
    public function addPromotion(Promotion $promotion)
    {
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
     * @return Questionnaire
     */
    public function setPromotions(ArrayCollection $promotions)
    {
        $this->promotions = $promotions;

        return $this;
    }

    /**
     * Get promotions
     *
     * @return ArrayCollection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Question
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
     * Set type
     *
     * @param integer $type
     *
     * @return Questionnaire
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateOuverture
     *
     * @param \DateTime $dateOuverture
     *
     * @return Questionnaire
     */
    public function setDateOuverture($dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;

        return $this;
    }

    /**
     * Get dateOuverture
     *
     * @return \DateTime
     */
    public function getDateOuverture()
    {
        return $this->dateOuverture;
    }

    /**
     * Set dateFermeture
     *
     * @param \DateTime $dateFermeture
     *
     * @return Questionnaire
     */
    public function setDateFermeture($dateFermeture)
    {
        $this->dateFermeture = $dateFermeture;

        return $this;
    }

    /**
     * Get dateFermeture
     *
     * @return \DateTime
     */
    public function getDateFermeture()
    {
        return $this->dateFermeture;
    }

    /**
     * Add question
     *
     * @param Question $question
     *
     * @return Questionnaire
     */
    public function addQuestion(Question $question)
    {
        $question->addQuestionnaire($this);

        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    /**
     * Remove question
     *
     * @param Question $question
     *
     * @return Questionnaire
     */
    public function removeQuestion(Question $question)
    {
        $question->removeQuestionnaire($this);

        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    /**
     * Set questions
     *
     * @param ArrayCollection $questions
     *
     * @return Questionnaire
     */
    public function setQuestions(ArrayCollection $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get questions
     *
     * @return ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param integer $type
     *
     * @return String
     */
    public function typeIs($type) {
        switch ($type)
        {
            case 1:
                return 'Rapport d\'activité au centre de formation';
                break;
            case 2:
                return 'Rapport d\'activité en entreprise';
                break;
            case 3:
                return 'Évaluation en entreprise';
                break;
            case 4:
                return 'Visite en entreprise';
                break;
            case 5:
                return 'Missions en entreprise';
                break;
        }
    }
}
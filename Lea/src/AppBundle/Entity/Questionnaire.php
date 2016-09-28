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
     * @var int
     * @ORM\Column(name="delai", type="integer", nullable=true)
     */
    private $delai;

    /**
     * @var ArrayCollection $questions
     * Owning Side
     * @ORM\ManyToMany(targetEntity="Question", inversedBy="questionnaires", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="questionnaire_questions", joinColumns={@ORM\JoinColumn(name="id_questionnaire", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="id_question", referencedColumnName="id")})
     */
    private $questions;


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
     * Set delai
     *
     * @param integer $delai
     *
     * @return Questionnaire
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return int
     */
    public function getDelai()
    {
        return $this->delai;
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
}
<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToMany(targetEntity="Promotion", inversedBy="questionnaires")
     * @ORM\JoinTable(name="promotion_questionnaires")
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
     * @ORM\ManyToMany(targetEntity="Question", mappedBy="questionnaires")
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
     * Add promotions
     *
     * @param Promotion $promotions
     *
     * @return Questionnaire
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
     * @return Questionnaire
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
     * Add questions
     *
     * @param Question $questions
     *
     * @return Questionnaire
     */
    public function addQuestion(Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Set questions
     *
     * @param Collection $questions
     *
     * @return Questionnaire
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get questions
     *
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
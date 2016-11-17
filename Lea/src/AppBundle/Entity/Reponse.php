<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Entity
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReponseRepository")
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Questionnaire_Individualise $questionnaire_individualise
     * @ORM\ManyToOne(targetEntity="Questionnaire_Individualise", inversedBy="reponses", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_questionnaire_individualise", referencedColumnName="id")
     */
    private $questionnaire_individualise;

    /**
     * @var Question $question
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="reponses", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
     */
    private $question;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

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
     * Set questionnaire_individualise
     *
     * @param Questionnaire_Individualise $questionnaire_individualise
     *
     * @return Reponse
     */
    public function setQuestionnaireIndividualise($questionnaire_individualise)
    {
        $this->questionnaire_individualise = $questionnaire_individualise;

        return $this;
    }

    /**
     * Get questionnaire_individualise
     *
     * @return Questionnaire_Individualise
     */
    public function getQuestionnaireIndividualise()
    {
        return $this->questionnaire_individualise;
    }

    /**
     * Set question
     *
     * @param Question $question
     *
     * @return Reponse
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Reponse
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
}
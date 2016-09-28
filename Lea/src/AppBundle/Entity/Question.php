<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Entity
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection $questionnaires
     * Inverse Side
     * @ORM\ManyToMany(targetEntity="Questionnaire", mappedBy="questions", cascade={"persist", "merge"})
     */
    private $questionnaires;

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
     * @var int
     * @ORM\Column(name="cible", type="integer")
     */
    private $cible;


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
     * Add questionnaire
     *
     * @param Questionnaire $questionnaire
     *
     * @return Question
     */
    public function addQuestionnaire(Questionnaire $questionnaire)
    {
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
     * @return Question
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
     * @return Question
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
     * Set cible
     *
     * @param integer $cible
     *
     * @return Question
     */
    public function setCible($cible)
    {
        $this->cible = $cible;

        return $this;
    }

    /**
     * Get cible
     *
     * @return int
     */
    public function getCible()
    {
        return $this->cible;
    }

    /**
     * @param integer $type
     *
     * @return String
     */
    public function typeIs($type) {
        switch ($type)
        {
            case 0:
                return 'Rapport d\'activité au centre de formation';
                break;
            case 1:
                return 'Rapport d\'activité en entreprise';
                break;
            case 2:
                return 'Évaluation en entreprise';
                break;
            case 3:
                return 'Visite en entreprise';
                break;
            case 4:
                return 'Missions en entreprise';
                break;
        }
    }

    /**
     * @param integer $cible
     *
     * @return String
     */
    public function cibleIs($cible) {
        switch ($cible)
        {
            case 0:
                return 'Étudiant';
                break;
            case 1:
                return 'Tuteur pédagogique';
                break;
            case 2:
                return 'Maître d\'apprentissage';
                break;
        }
    }
}


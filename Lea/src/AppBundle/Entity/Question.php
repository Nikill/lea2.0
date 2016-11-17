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
     * @ORM\Column(name="type_question", type="integer")
     */
    private $typeQuestion;

    /**
     * @var int
     * @ORM\Column(name="cible", type="integer")
     */
    private $cible;

    /**
     * @var ArrayCollection $choix
     * Owning Side
     * @ORM\ManyToMany(targetEntity="Choix", inversedBy="questions", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="question_choix", joinColumns={@ORM\JoinColumn(name="id_question", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="id_choix", referencedColumnName="id")})
     * @ORM\OrderBy({"rang"="ASC"})
     */
    private $choix;

    /**
     * @var ArrayCollection $reponses
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="question", cascade={"persist", "remove", "merge"})
     */
    private $reponses;


    public function __construct() {
        $this->questionnaires = new ArrayCollection();
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
     * Remove questionnaire
     *
     * @param Questionnaire $questionnaire
     *
     * @return Question
     */
    public function removeQuestionnaire(Questionnaire $questionnaire)
    {
        if ($this->questionnaires->contains($questionnaire)) {
            $this->questionnaires->removeElement($questionnaire);
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
     * Set typeQuestion
     *
     * @param integer $typeQuestion
     *
     * @return Question
     */
    public function setTypeQuestion($typeQuestion)
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }

    /**
     * Get typeQuestion
     *
     * @return int
     */
    public function getTypeQuestion()
    {
        return $this->typeQuestion;
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
     * Add choix
     *
     * @param Choix $choix
     *
     * @return Question
     */
    public function addChoix(Choix $choix)
    {
        $choix->addQuestion($this);

        if (!$this->choix->contains($choix)) {
            $this->choix->add($choix);
        }

        return $this;
    }

    /**
     * Remove choix
     *
     * @param Choix $choix
     *
     * @return Question
     */
    public function removeChoix(Choix $choix)
    {
        $choix->removeQuestion($this);

        if ($this->choix->contains($choix)) {
            $this->choix->removeElement($choix);
        }

        return $this;
    }

    /**
     * Set choix
     *
     * @param ArrayCollection $choix
     *
     * @return Question
     */
    public function setChoix(ArrayCollection $choix)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix
     *
     * @return ArrayCollection
     */
    public function getChoix()
    {
        return $this->choix;
    }

    /**
     * Add reponse
     *
     * @param Reponse $reponse
     *
     * @return Question
     */
    public function addReponse(Reponse $reponse)
    {
        $reponse->setQuestion($this);

        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
        }

        return $this;
    }

    /**
     * Set reponses
     *
     * @param ArrayCollection $reponses
     *
     * @return Question
     */
    public function setReponses(ArrayCollection $reponses)
    {
        $this->reponses = $reponses;

        return $this;
    }

    /**
     * Get reponses
     *
     * @return ArrayCollection $reponses
     */
    public function getReponses()
    {
        return $this->reponses;
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

    /**
     * @param integer $typeQuestion
     *
     * @return String
     */
    public function typeQuestionIs($typeQuestion) {
        switch ($typeQuestion)
        {
            case 1:
                return 'Texte libre';
                break;
            case 2:
                return 'Liste à choix unique';
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
            case 1:
                return 'Étudiant';
                break;
            case 2:
                return 'Tuteur pédagogique';
                break;
            case 3:
                return 'Maître d\'apprentissage';
                break;
        }
    }
}


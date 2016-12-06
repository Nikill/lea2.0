<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire_Individualise
 *
 * @ORM\Entity
 * @ORM\Table(name="questionnaire__individualise")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Questionnaire_IndividualiseRepository")
 */
class Questionnaire_Individualise
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Contrat $contrat
     * @ORM\ManyToOne(targetEntity="Contrat", inversedBy="questionnaires_individualises", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_contrat", referencedColumnName="id")
     */
    private $contrat;

    /**
     * @var Questionnaire $questionnaire
     * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="questionnaires_individualises", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="id_questionnaire", referencedColumnName="id")
     */
    private $questionnaire;

    /**
     * @var bool
     * @ORM\Column(name="signature_etudiant", type="boolean")
     */
    private $signatureEtudiant;

    /**
     * @var bool
     * @ORM\Column(name="signature_tuteur", type="boolean")
     */
    private $signatureTuteur;

    /**
     * @var bool
     * @ORM\Column(name="signature_map", type="boolean")
     */
    private $signatureMap;

    /**
     * @var ArrayCollection $reponses
     * @ORM\OneToMany(targetEntity="Reponse", mappedBy="questionnaire_individualise", cascade={"persist", "remove", "merge"})
     */
    private $reponses;

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
     * Set contrat
     *
     * @param Contrat $contrat
     *
     * @return Questionnaire_Individualise
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get contrat
     *
     * @return Contrat
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * Set questionnaire
     *
     * @param Questionnaire $questionnaire
     *
     * @return Questionnaire_Individualise
     */
    public function setQuestionnaire($questionnaire)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * Set signatureEtudiant
     *
     * @param boolean $signatureEtudiant
     *
     * @return Questionnaire_Individualise
     */
    public function setSignatureEtudiant($signatureEtudiant)
    {
        $this->signatureEtudiant = $signatureEtudiant;

        return $this;
    }

    /**
     * Get signatureEtudiant
     *
     * @return bool
     */
    public function getSignatureEtudiant()
    {
        return $this->signatureEtudiant;
    }

    /**
     * Set signatureTuteur
     *
     * @param boolean $signatureTuteur
     *
     * @return Questionnaire_Individualise
     */
    public function setSignatureTuteur($signatureTuteur)
    {
        $this->signatureTuteur = $signatureTuteur;

        return $this;
    }

    /**
     * Get signatureTuteur
     *
     * @return bool
     */
    public function getSignatureTuteur()
    {
        return $this->signatureTuteur;
    }

    /**
     * Set signatureMap
     *
     * @param boolean $signatureMap
     *
     * @return Questionnaire_Individualise
     */
    public function setSignatureMap($signatureMap)
    {
        $this->signatureMap = $signatureMap;

        return $this;
    }

    /**
     * Get signatureMap
     *
     * @return bool
     */
    public function getSignatureMap()
    {
        return $this->signatureMap;
    }

    /**
     * Add reponse
     *
     * @param Reponse $reponse
     *
     * @return Questionnaire_Individualise
     */
    public function addReponse(Reponse $reponse)
    {
        $reponse->setQuestionnaireIndividualise($this);

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
     * @return Questionnaire_Individualise
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
}
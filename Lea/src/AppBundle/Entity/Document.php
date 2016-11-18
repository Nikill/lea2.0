<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeDocument")
     */
    private $typeDocument;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AnneeScolaire")
     */
    private $anneeScolaire;

    /**
     * @var string
     *
     * @ORM\Column(name="nomFichier", type="string", length=255)
     */
    private $nomFichier;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var bool
     *
     * @ORM\Column(name="visibleMAP", type="boolean")
     */
    private $visibleMAP;
    /**
     * @var bool
     *
     * @ORM\Column(name="visibleTuteur", type="boolean")
     */
    private $visibleTuteur;

    /**
     * @var bool
     *
     * @ORM\Column(name="visibleResponsable", type="boolean")
     */
    private $visibleResponsable;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Document
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set canView
     *
     * @param string $canView
     *
     * @return Document
     */
    public function setCanView($canView)
    {
        $this->canView = $canView;

        return $this;
    }

    /**
     * Get canView
     *
     * @return string
     */
    public function getCanView()
    {
        return $this->canView;
    }

    /**
     * @return mixed
     */
    public function getTypeDocument()
    {
        return $this->typeDocument;
    }

    /**
     * @param mixed $typeDocument
     */
    public function setTypeDocument($typeDocument)
    {
        $this->typeDocument = $typeDocument;
    }

    /**
     * @return mixed
     */
    public function getAnneeScolaire()
    {
        return $this->anneeScolaire;
    }

    /**
     * @param mixed $anneeScolaire
     */
    public function setAnneeScolaire($anneeScolaire)
    {
        $this->anneeScolaire = $anneeScolaire;
    }

    /**
     * @return mixed
     */
    public function getNomFichier()
    {
        return $this->nomFichier;
    }

    /**
     * @param mixed $nomFichier
     */
    public function setNomFichier($nomFichier)
    {
        $this->nomFichier = $nomFichier;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return boolean
     */
    public function isVisibleMAP()
    {
        return $this->visibleMAP;
    }

    /**
     * @param boolean $visibleMAP
     */
    public function setVisibleMAP($visibleMAP)
    {
        $this->visibleMAP = $visibleMAP;
    }

    /**
     * @return boolean
     */
    public function isVisibleTuteur()
    {
        return $this->visibleTuteur;
    }

    /**
     * @param boolean $visibleTuteur
     */
    public function setVisibleTuteur($visibleTuteur)
    {
        $this->visibleTuteur = $visibleTuteur;
    }

    /**
     * @return boolean
     */
    public function isVisibleResponsable()
    {
        return $this->visibleResponsable;
    }

    /**
     * @param boolean $visibleResponsable
     */
    public function setVisibleResponsable($visibleResponsable)
    {
        $this->visibleResponsable = $visibleResponsable;
    }
}
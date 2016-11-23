<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     * @ORM\Column(name="codePostal", type="string", length=5, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     * @ORM\Column(name="telephoneFix", type="string", length=10, nullable=true)
     */
    private $telephoneFix;

    /**
     * @var string
     * @ORM\Column(name="telephonePortable", type="string", length=10, nullable=true)
     */
    private $telephonePortable;

    /**
     * @var string
     * @ORM\Column(name="fax", type="string", length=10, nullable=true)
     */
    private $fax;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     * @ORM\Column(name="estHandicape", type="boolean")
     */
    private $estHandicape;

    /**
     * @var ArrayCollection $contrats
     * Owning Side
     * @ORM\ManyToMany(targetEntity="Contrat", inversedBy="users", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="user_contrats", joinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="id_contrat", referencedColumnName="id")})
     */
    private $contrats;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // details and/on creation date
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getTelephoneFix()
    {
        return $this->telephoneFix;
    }

    /**
     * @param mixed $telephoneFix
     */
    public function setTelephoneFix($telephoneFix)
    {
        $this->telephoneFix = $telephoneFix;
    }

    /**
     * @return mixed
     */
    public function getTelephonePortable()
    {
        return $this->telephonePortable;
    }

    /**
     * @param mixed $telephonePortable
     */
    public function setTelephonePortable($telephonePortable)
    {
        $this->telephonePortable = $telephonePortable;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param \DateTime $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return string
     */
    public function getEstHandicape()
    {
        return $this->estHandicape;
    }

    /**
     * @param string $estHandicape
     */
    public function setEstHandicape($estHandicape)
    {
        $this->estHandicape = $estHandicape;
    }

    /**
     * Add contrat
     *
     * @param Contrat $contrat
     *
     * @return User
     */
    public function addContrat(Contrat $contrat)
    {
        $contrat->addUser($this);

        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
        }

        return $this;
    }

    /**
     * Remove contrat
     *
     * @param Contrat $contrat
     *
     * @return User
     */
    public function removeContrat(Contrat $contrat)
    {
        $contrat->removeUser($this);

        if ($this->contrats->contains($contrat)) {
            $this->contrats->removeElement($contrat);
        }

        return $this;
    }

    /**
     * Set contrats
     *
     * @param ArrayCollection $contrats
     *
     * @return User
     */
    public function setContrats(ArrayCollection $contrats)
    {
        $this->contrats = $contrats;

        return $this;
    }

    /**
     * Get contrats
     *
     * @return ArrayCollection
     */
    public function getContrats()
    {
        return $this->contrats;
    }
}
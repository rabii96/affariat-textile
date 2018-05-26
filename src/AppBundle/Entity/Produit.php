<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="nomprod", type="string", length=255)
     */
    private $nomprod;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $categorie;

      /**
     * @ORM\ManyToOne(targetEntity="SousCategorie")
     * @ORM\JoinColumn(name="sousCategorie", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $sousCategorie;

    /**
     * @var string
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=255)
     */
     private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumn(name="ville", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $ville;


    /**
    * @ORM\ManyToOne(targetEntity="Annonceur")
    * @ORM\JoinColumn(name="id_annonceur", referencedColumnName="id" , onDelete="CASCADE")
    */
   private $id_annonceur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetime")
     */
    private $dateAjout;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="afficherNum", type="boolean")
     */
    private $afficherNum;


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
     * Set nomprod
     *
     * @param string $nomprod
     *
     * @return Produit
     */
    public function setNomprod($nomprod)
    {
        $this->nomprod = $nomprod;

        return $this;
    }

    /**
     * Get nomprod
     *
     * @return string
     */
    public function getNomprod()
    {
        return $this->nomprod;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
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
     * Set image
     *
     * @param string $image
     *
     * @return Produit
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    

    /**
     * Set idAnnonceur
     *
     * @param \AppBundle\Entity\Annonceur $idAnnonceur
     *
     * @return Produit
     */
    public function setIdAnnonceur(\AppBundle\Entity\Annonceur $idAnnonceur = null)
    {
        $this->id_annonceur = $idAnnonceur;

        return $this;
    }

    /**
     * Get idAnnonceur
     *
     * @return \AppBundle\Entity\Annonceur
     */
    public function getIdAnnonceur()
    {
        return $this->id_annonceur;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Produit
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }



    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return Produit
     */
    public function setRegion(\AppBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Produit
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Produit
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sousCategorie
     *
     * @param \AppBundle\Entity\SousCategorie $sousCategorie
     *
     * @return Produit
     */
    public function setSousCategorie(\AppBundle\Entity\SousCategorie $sousCategorie = null)
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    /**
     * Get sousCategorie
     *
     * @return \AppBundle\Entity\SousCategorie
     */
    public function getSousCategorie()
    {
        return $this->sousCategorie;
    }

    /**
     * Set ville
     *
     * @param \AppBundle\Entity\Ville $ville
     *
     * @return Produit
     */
    public function setVille(\AppBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AppBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set afficherNum
     *
     * @param boolean $afficherNum
     *
     * @return Produit
     */
    public function setAfficherNum($afficherNum)
    {
        $this->afficherNum = $afficherNum;

        return $this;
    }

    /**
     * Get afficherNum
     *
     * @return boolean
     */
    public function getAfficherNum()
    {
        return $this->afficherNum;
    }
}

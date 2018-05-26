<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archive
 *
 * @ORM\Table(name="archive")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArchiveRepository")
 */
class Archive
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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="datetimetz")
     */
    private $dateAjout;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_suppression", type="datetimetz")
     */
    private $dateSuppression;

    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region", referencedColumnName="id")
     */
    private $region;


    /**
     * @ORM\ManyToOne(targetEntity="Annonceur")
     * @ORM\JoinColumn(name="id_annonceur", referencedColumnName="id")
     */
    private $id_annonceur;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="SousCategorie")
     * @ORM\JoinColumn(name="sousCategorie", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $sousCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumn(name="ville", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * @return Archive
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
     * @return Archive
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
     * @return Archive
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
     * @return Archive
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
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Archive
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
     * Set dateSuppression
     *
     * @param \DateTime $dateSuppression
     *
     * @return Archive
     */
    public function setDateSuppression($dateSuppression)
    {
        $this->dateSuppression = $dateSuppression;

        return $this;
    }

    /**
     * Get dateSuppression
     *
     * @return \DateTime
     */
    public function getDateSuppression()
    {
        return $this->dateSuppression;
    }

    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return Archive
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
     * Set idAnnonceur
     *
     * @param \AppBundle\Entity\Annonceur $idAnnonceur
     *
     * @return Archive
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
     * @return Archive
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
     * Set type
     *
     * @param string $type
     *
     * @return Archive
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
     * @return Archive
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
     * @return Archive
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
}

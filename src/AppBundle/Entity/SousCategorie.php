<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousCategorie
 *
 * @ORM\Table(name="sous_categorie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SousCategorieRepository")
 */
class SousCategorie
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
     * @ORM\Column(name="nomSousCategorie", type="string", length=255)
     */
    private $nomSousCategorie;


    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="sousCategorie")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     */
    private $categorie;


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
     * Set nomSousCategorie
     *
     * @param string $nomSousCategorie
     *
     * @return SousCategorie
     */
    public function setNomSousCategorie($nomSousCategorie)
    {
        $this->nomSousCategorie = $nomSousCategorie;

        return $this;
    }

    /**
     * Get nomSousCategorie
     *
     * @return string
     */
    public function getNomSousCategorie()
    {
        return $this->nomSousCategorie;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return SousCategorie
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
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegionRepository")
 */
class Region
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
     * @ORM\Column(name="nomRegion", type="string", length=255, unique=true)
     */
    private $nomRegion;


    /**
     * @ORM\OneToMany(targetEntity="Ville", mappedBy="region" , cascade={"remove"})
     */
    private $ville;


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
     * Set nomRegion
     *
     * @param string $nomRegion
     *
     * @return Region
     */
    public function setNomRegion($nomRegion)
    {
        $this->nomRegion = $nomRegion;

        return $this;
    }

    /**
     * Get nomRegion
     *
     * @return string
     */
    public function getNomRegion()
    {
        return $this->nomRegion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ville = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add ville
     *
     * @param \AppBundle\Entity\Ville $ville
     *
     * @return Region
     */
    public function addVille(\AppBundle\Entity\Ville $ville)
    {
        $this->ville[] = $ville;

        return $this;
    }

    /**
     * Remove ville
     *
     * @param \AppBundle\Entity\Ville $ville
     */
    public function removeVille(\AppBundle\Entity\Ville $ville)
    {
        $this->ville->removeElement($ville);
    }

    /**
     * Get ville
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVille()
    {
        return $this->ville;
    }
}

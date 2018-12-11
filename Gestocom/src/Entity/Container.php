<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContainerRepository")
 */
class Container
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $volume;

    /**
     * @ORM\Column(type="float")
     */
    private $poidsBrut;

    /**
     * @ORM\Column(type="float")
     */
    private $chargeUtile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Habitation", inversedBy="containers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $habitation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Levee", mappedBy="container")
     */
    private $levees;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDechet", inversedBy="containers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeDechet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    public function __construct()
    {
        $this->levees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getPoidsBrut(): ?float
    {
        return $this->poidsBrut;
    }

    public function setPoidsBrut(float $poidsBrut): self
    {
        $this->poidsBrut = $poidsBrut;

        return $this;
    }

    public function getChargeUtile(): ?float
    {
        return $this->chargeUtile;
    }

    public function setChargeUtile(float $chargeUtile): self
    {
        $this->chargeUtile = $chargeUtile;

        return $this;
    }

    public function getHabitation(): ?Habitation
    {
        return $this->habitation;
    }

    public function setHabitation(?Habitation $habitation): self
    {
        $this->habitation = $habitation;

        return $this;
    }

    /**
     * @return Collection|Levee[]
     */
    public function getLevees(): Collection
    {
        return $this->levees;
    }

    public function addLevee(Levee $levee): self
    {
        if (!$this->levees->contains($levee)) {
            $this->levees[] = $levee;
            $levee->setContainer($this);
        }

        return $this;
    }

    public function removeLevee(Levee $levee): self
    {
        if ($this->levees->contains($levee)) {
            $this->levees->removeElement($levee);
            // set the owning side to null (unless already changed)
            if ($levee->getContainer() === $this) {
                $levee->setContainer(null);
            }
        }

        return $this;
    }

    public function getTypeDechet(): ?TypeDechet
    {
        return $this->typeDechet;
    }

    public function setTypeDechet(?TypeDechet $typeDechet): self
    {
        $this->typeDechet = $typeDechet;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }
}

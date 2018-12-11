<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeDechetRepository")
 */
class TypeDechet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Container", mappedBy="typeDechet")
     */
    private $containers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tarif", mappedBy="typeDechet")
     */
    private $tarifs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archiver;

    public function __construct()
    {
        $this->containers = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Container[]
     */
    public function getContainers(): Collection
    {
        return $this->containers;
    }

    public function addContainer(Container $container): self
    {
        if (!$this->containers->contains($container)) {
            $this->containers[] = $container;
            $container->setTypeDechet($this);
        }

        return $this;
    }

    public function removeContainer(Container $container): self
    {
        if ($this->containers->contains($container)) {
            $this->containers->removeElement($container);
            // set the owning side to null (unless already changed)
            if ($container->getTypeDechet() === $this) {
                $container->setTypeDechet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tarif[]
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Tarif $tarif): self
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs[] = $tarif;
            $tarif->setTypeDechet($this);
        }

        return $this;
    }

    public function removeTarif(Tarif $tarif): self
    {
        if ($this->tarifs->contains($tarif)) {
            $this->tarifs->removeElement($tarif);
            // set the owning side to null (unless already changed)
            if ($tarif->getTypeDechet() === $this) {
                $tarif->setTypeDechet(null);
            }
        }

        return $this;
    }

    public function getArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): self
    {
        $this->archiver = $archiver;

        return $this;
    }
}

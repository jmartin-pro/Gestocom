<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsagerRepository")
 */
class Usager
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $copos;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reclamation", mappedBy="usager")
     */
    private $reclamations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Habitation", mappedBy="usager")
     */
    private $habitations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->habitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCopos(): ?string
    {
        return $this->copos;
    }

    public function setCopos(string $copos): self
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setUsager($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->contains($reclamation)) {
            $this->reclamations->removeElement($reclamation);
            // set the owning side to null (unless already changed)
            if ($reclamation->getUsager() === $this) {
                $reclamation->setUsager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Habitation[]
     */
    public function getHabitations(): Collection
    {
        return $this->habitations;
    }

    public function addHabitation(Habitation $habitation): self
    {
        if (!$this->habitations->contains($habitation)) {
            $this->habitations[] = $habitation;
            $habitation->setUsager($this);
        }

        return $this;
    }

    public function removeHabitation(Habitation $habitation): self
    {
        if ($this->habitations->contains($habitation)) {
            $this->habitations->removeElement($habitation);
            // set the owning side to null (unless already changed)
            if ($habitation->getUsager() === $this) {
                $habitation->setUsager(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDechet", inversedBy="tarifs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeDechet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

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
}

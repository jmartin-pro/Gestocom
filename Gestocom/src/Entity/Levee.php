<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeveeRepository")
 */
class Levee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLevee;

    /**
     * @ORM\Column(type="float")
     */
    private $poids;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Container", inversedBy="levees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $container;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLevee(): ?\DateTimeInterface
    {
        return $this->dateLevee;
    }

    public function setDateLevee(\DateTimeInterface $dateLevee): self
    {
        $this->dateLevee = $dateLevee;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setContainer(?Container $container): self
    {
        $this->container = $container;

        return $this;
    }
}

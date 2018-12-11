<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Utilisateur;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponsableRepository")
 */
class Responsable extends Utilisateur
{

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }
    
    public function getDisc(): ?string
    {
        return "responsable";
    }
}

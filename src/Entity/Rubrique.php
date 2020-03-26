<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RubriqueRepository")
 */
class Rubrique
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiche", inversedBy="rubrique")
     */
    private $fiche;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Organisme", inversedBy="rubrique")
     */
    private $organisme;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $titre;



    /**
     * @ORM\Column(type="integer")
     */
    private $classement;

    public function __construct()
    {
        $this->organisme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getClassement(): ?int
    {
        return $this->classement;
    }

    public function setClassement(int $classement): self
    {
        $this->classement = $classement;

        return $this;
    }

    public function getFiche(): ?Fiche
    {
        return $this->fiche;
    }

    public function setFiche(?Fiche $fiche): self
    {
        $this->fiche = $fiche;

        return $this;
    }


    //public function getOrganisme(): ?Organisme
    public function getOrganisme(): Collection
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }
    public function addOrganisme(Organisme $organisme): self
    {
        if (!$this->organisme->contains($organisme)) {
            $this->organisme[] = $organisme;
        }

        return $this;
    }

    public function removeOrganisme(Organisme $organisme): self
    {
        if ($this->organisme->contains($organisme)) {
            $this->organisme->removeElement($organisme);
        }

        return $this;
    }


}

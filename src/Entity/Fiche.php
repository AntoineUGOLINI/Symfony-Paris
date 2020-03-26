<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\FicheController;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheRepository")
 */
class Fiche
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="fiche")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rubrique", mappedBy="fiche")
     */
    private $rubrique;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer",nullable=true)
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modif_auto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chapeau;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_edition;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_pub;
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $valid;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $voiraussi;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $classement;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numpage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numpagefin;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $partie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etoile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $theme_web;

    public function __construct()
    {
        $this->rubrique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModifAuto(): ?\DateTimeInterface
    {
        return $this->modif_auto;
    }

    public function setModifAuto(?\DateTimeInterface $modif_auto): self
    {
        $this->modif_auto = $modif_auto;

        return $this;
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

    public function getChapeau(): ?string
    {
        return $this->chapeau;
    }

    public function setChapeau(string $chapeau): self
    {
        $this->chapeau = $chapeau;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->date_edition;
    }

    public function setDateEdition(\DateTimeInterface $date_edition): self
    {
        $this->date_edition = $date_edition;

        return $this;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->date_pub;
    }

    public function setDatePub(\DateTimeInterface $date_pub): self
    {
        $this->date_pub = $date_pub;

        return $this;
    }

    public function getValid(): ?string
    {
        return $this->valid;
    }

    public function setValid(string $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
    public function getVoiraussi(): ?string
    {
        return $this->voiraussi;
    }

    public function setVoiraussi(string $voiraussi): self
    {
        $this->voiraussi = $voiraussi;

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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getNumpage(): ?int
    {
        return $this->numpage;
    }

    public function setNumpage(int $numpage): self
    {
        $this->numpage = $numpage;

        return $this;
    }

    public function getNumpagefin(): ?int
    {
        return $this->numpagefin;
    }

    public function setNumpagefin(int $numpagefin): self
    {
        $this->numpagefin = $numpagefin;

        return $this;
    }

    public function getPartie(): ?string
    {
        return $this->partie;
    }

    public function setPartie(string $partie): self
    {
        $this->partie = $partie;

        return $this;
    }

    public function getEtoile(): ?int
    {
        return $this->etoile;
    }

    public function setEtoile(int $etoile): self
    {
        $this->etoile = $etoile;

        return $this;
    }

    public function getThemeWeb(): ?string
    {
        return $this->theme_web;
    }

    public function setThemeWeb(string $theme_web): self
    {
        $this->theme_web = $theme_web;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Rubrique[]
     */
    public function getRubrique(): Collection
    {
        return $this->rubrique;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubrique->contains($rubrique)) {
            $this->rubrique[] = $rubrique;
            $rubrique->setFiche($this);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubrique->contains($rubrique)) {
            $this->rubrique->removeElement($rubrique);
            // set the owning side to null (unless already changed)
            if ($rubrique->getFiche() === $this) {
                $rubrique->setFiche(null);
            }
        }

        return $this;
    }



    }


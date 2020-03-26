<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fiche",mappedBy="user")
     */
    private $fiche;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Organisme",mappedBy="user")
     */
    private $organisme;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=150,nullable=true)
     */
    private $nom_off;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $nom_farm;

    /**
     * @ORM\Column(type="string", length=200,nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=10,nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=10,nullable=true)
     */
    private $admin;

    public function __construct()
    {
        $this->fiche = new ArrayCollection();
        $this->organisme = new ArrayCollection();
    }


    /**
     * @see UserInterface
     */
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNomOff(): ?string
    {
        return $this->nom_off;
    }

    public function setNomOff(string $nom_off): self
    {
        $this->nom_off = $nom_off;

        return $this;
    }

    public function getNomFarm(): ?string
    {
        return $this->nom_farm;
    }

    public function setNomFarm(string $nom_farm): self
    {
        $this->nom_farm = $nom_farm;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

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

    public function getAdmin(): ?string
    {
        return $this->admin;
    }

    public function setAdmin(string $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection|Fiche[]
     */
    public function getFiche(): Collection
    {
        return $this->fiche;
    }

    public function addFiche(Fiche $fiche): self
    {
        if (!$this->fiche->contains($fiche)) {
            $this->fiche[] = $fiche;
            $fiche->setUser($this);
        }

        return $this;
    }

    public function removeFiche(Fiche $fiche): self
    {
        if ($this->fiche->contains($fiche)) {
            $this->fiche->removeElement($fiche);
            // set the owning side to null (unless already changed)
            if ($fiche->getUser() === $this) {
                $fiche->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Organisme[]
     */
    public function getOrganisme(): Collection
    {
        return $this->organisme;
    }

    public function addOrganisme(Organisme $organisme): self
    {
        if (!$this->organisme->contains($organisme)) {
            $this->organisme[] = $organisme;
            $organisme->setUser($this);
        }

        return $this;
    }

    public function removeOrganisme(Organisme $organisme): self
    {
        if ($this->organisme->contains($organisme)) {
            $this->organisme->removeElement($organisme);
            // set the owning side to null (unless already changed)
            if ($organisme->getUser() === $this) {
                $organisme->setUser(null);
            }
        }

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /// FIN-USERINTERFACE
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganismeRepository")
 */
class Organisme extends ServiceEntityRepository
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="organisme")
     */
    private $user;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Rubrique", mappedBy="organisme")
     */
    private $rubrique;

    // …
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $crea_auto;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modif_auto;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom_off;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_farm;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_siege;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $mouvance;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $cedex;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $acces;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $web;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modif_date;

    /**
     * @ORM\Column(type="text",length=255, nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $confidentiel;



    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $code_siege;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bonus;

    public function __construct()
    {
        $this->rubrique = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreaAuto(): ?\DateTimeInterface
    {
        return $this->crea_auto;
    }

    public function setCreaAuto(\DateTimeInterface $crea_auto): self
    {
        $this->crea_auto = $crea_auto;

        return $this;
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

    public function getNomSiege(): ?string
    {
        return $this->nom_siege;
    }

    public function setNomSiege(string $nom_siege): self
    {
        $this->nom_siege = $nom_siege;

        return $this;
    }

    public function getMouvance(): ?string
    {
        return $this->mouvance;
    }

    public function setMouvance(string $mouvance): self
    {
        $this->mouvance = $mouvance;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

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

    public function getCedex(): ?string
    {
        return $this->cedex;
    }

    public function setCedex(string $cedex): self
    {
        $this->cedex = $cedex;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getAcces(): ?string
    {
        return $this->acces;
    }

    public function setAcces(string $acces): self
    {
        $this->acces = $acces;

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

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(string $tel2): self
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getResWeb(): ?string
    {
        return $this->res_web;
    }

    public function setResWeb(?string $res_web): self
    {
        $this->res_web = $res_web;

        return $this;
    }

    public function getResDet(): ?string
    {
        return $this->res_det;
    }

    public function setResDet(?string $res_det): self
    {
        $this->res_det = $res_det;

        return $this;
    }

    public function getRem(): ?string
    {
        return $this->rem;
    }

    public function setRem(?string $rem): self
    {
        $this->rem = $rem;

        return $this;
    }

    public function getIdRubweb(): ?int
    {
        return $this->id_rubweb;
    }

    public function setIdRubweb(?int $id_rubweb): self
    {
        $this->id_rubweb = $id_rubweb;

        return $this;
    }

    public function getIdEdb(): ?string
    {
        return $this->id_edb;
    }

    public function setIdEdb(?string $id_edb): self
    {
        $this->id_edb = $id_edb;

        return $this;
    }

    public function getValidEdb(): ?string
    {
        return $this->valid_edb;
    }

    public function setValidEdb(?string $valid_edb): self
    {
        $this->valid_edb = $valid_edb;

        return $this;
    }

    public function getValidWeb(): ?string
    {
        return $this->valid_web;
    }

    public function setValidWeb(?string $valid_web): self
    {
        $this->valid_web = $valid_web;

        return $this;
    }

    public function getModifDate(): ?\DateTimeInterface
    {
        return $this->modif_date;
    }

    public function setModifDate(?\DateTimeInterface $modif_date): self
    {
        $this->modif_date = $modif_date;

        return $this;
    }

    public function getConfidentiel(): ?string
    {
        return $this->confidentiel;
    }

    public function setConfidentiel(?string $confidentiel): self
    {
        $this->confidentiel = $confidentiel;

        return $this;
    }

    public function getCodeSiege(): ?string
    {
        return $this->code_siege;
    }

    public function setCodeSiege(string $code_siege): self
    {
        $this->code_siege = $code_siege;

        return $this;
    }

    public function getBonus(): ?string
    {
        return $this->bonus;
    }

    public function setBonus(string $bonus): self
    {
        $this->bonus = $bonus;

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
            $rubrique->setOrganisme($this);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        if ($this->rubrique->contains($rubrique)) {
            $this->rubrique->removeElement($rubrique);
            // set the owning side to null (unless already changed)
            if ($rubrique->getOrganisme() === $this) {
                $rubrique->setOrganisme(null);
            }
        }

        return $this;
    }

    public function getResume()
    {
        return $this->resume;
    }

    public function setResume($resume): self
    {
        $this->resume = $resume;

        return $this;
    }
/*    public function findByRub($organismes,Rubrique $rubriques){
        $query = $this->createQueryBuilder('o')
            ->select('o.rubrique')
            ->setParameter($rubriques,'rubrique.organisme')
            ->leftJoin('rubrique.organisme', 'r')
            ->where('o==r', 'v')
            ->orderBy('r', 'DESC')
            ->setParameter('v',$organismes)
            ->getQuery()
            ->getResult();
        return $query;
    }*/
}

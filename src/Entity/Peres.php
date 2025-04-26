<?php

namespace App\Entity;

use App\Repository\PeresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;

#[ORM\Entity(repositoryClass: PeresRepository::class)]
#[ORM\Table(name: 'peres')]
#[ORM\Index(name: 'idx_peres_nom', columns: ['nom_id'])]
#[ORM\Index(name: 'idx_peres_prenom', columns: ['prenom_id'])]
#[ORM\Index(name: 'idx_peres_profession', columns: ['profession_id'])]
#[ORM\Index(name: 'idx_peres_nina', columns: ['nina_id'])]
#[ORM\Index(name: 'idx_peres_telephone1', columns: ['telephone1_id'])]
#[ORM\Index(name: 'idx_peres_telephone2', columns: ['telephone2_id'])]
#[ORM\Index(name: 'idx_peres_fullname', columns: ['fullname'])]
#[ORM\Index(name: 'idx_peres_email', columns: ['email'])]
class Peres
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le nom ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getNom() !== null",
        message: 'Le nom ne peut pas être vide'
    )]
    private ?Noms $nom = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Le prénom ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le prénom ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getPrenom() !== null",
        message: 'Le prénom ne peut pas être vide'
    )]
    private ?Prenoms $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'peres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'La profession ne peut pas être vide')]
    #[Assert\NotNull(message: 'La profession ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getProfession() !== null",
        message: 'La profession ne peut pas être vide'
    )]
    private ?Professions $profession = null;

    #[ORM\OneToOne(inversedBy: 'peres', targetEntity: Ninas::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "nina_id", referencedColumnName: "id",nullable: true)]
    private ?Ninas $nina = null;

    #[ORM\OneToOne(inversedBy: 'peres', targetEntity: Telephones1::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "telephone1_id", referencedColumnName: "id",nullable: false)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone 1 ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le numéro de téléphone 1 ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getTelephone1() !== null",
        message: 'Le numéro de téléphone 1 ne peut pas être vide'
    )]
    private ?Telephones1 $telephone1 = null;

    #[ORM\OneToOne(inversedBy: 'peres', targetEntity: Telephones2::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "telephone2_id", referencedColumnName: "id",nullable: true)]
    #[Assert\Valid]
    private ?Telephones2 $telephone2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "Le nom complet ne peut pas dépasser {{ limit }} caractères"
    )]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Expression(
        "this.getFullname() !== null",
        message: 'Le nom complet ne peut pas être vide'
    )]
    #[Assert\NotBlank(message: 'Le nom complet ne peut pas être vide')]
    private ?string $fullname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Email(
        message: "L'adresse email '{{ value }}' n'est pas valide.",
        mode: 'strict'
    )]
    #[Assert\Regex(
        pattern: "/^[\p{L}0-9._%+-]+@[\p{L}0-9.-]+\.[\p{L}]{2,}$/u",
        message: "Utilisez un format international valide (ex: utilisateur@exemple.中国)"
    )]
    #[Assert\Length(
        max: 150,
        maxMessage: "L'email ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, Parents>
     */
    #[ORM\OneToMany(targetEntity: Parents::class, mappedBy: 'pere')]
    private Collection $parents;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?Noms
    {
        return $this->nom;
    }

    public function setNom(?Noms $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?Prenoms
    {
        return $this->prenom;
    }

    public function setPrenom(?Prenoms $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfession(): ?Professions
    {
        return $this->profession;
    }

    public function setProfession(?Professions $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getNina(): ?Ninas
    {
        return $this->nina;
    }

    public function setNina(?Ninas $nina): static
    {
        $this->nina = $nina;

        return $this;
    }

    public function getTelephone1(): ?Telephones1
    {
        return $this->telephone1;
    }

    public function setTelephone1(Telephones1 $telephone1): static
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?telephones2
    {
        return $this->telephone2;
    }

    public function setTelephone2(?telephones2 $telephone2): static
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->fullname ?? '';
    }

    /**
     * @return Collection<int, Parents>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Parents $parent): static
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
            $parent->setPere($this);
        }

        return $this;
    }

    public function removeParent(Parents $parent): static
    {
        if ($this->parents->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getPere() === $this) {
                $parent->setPere(null);
            }
        }

        return $this;
    }
}

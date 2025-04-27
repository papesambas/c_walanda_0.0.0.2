<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\ProfessionsRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProfessionsRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_PROFESSION', fields: ['designation'])]
#[UniqueEntity(fields: ['designation'], message: "cette profession est pas disponible")]
#[ORM\Table(name: 'professions')]
#[ORM\Index(name: 'idx_professions_designation', columns: ['designation'])]
class Professions
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 130)]
    #[Assert\NotBlank(message: 'La profession ne peut pas être vide')]
    #[Assert\NotNull(message: 'La profession ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 2,
        max: 130,
        minMessage: "La profession doit avoir au moins {{ limit }} caractères.",
        maxMessage: "La profession ne peut dépasser {{ limit }} caractères."
    )]
    private ?string $designation = null;

    /**
     * @var Collection<int, Peres>
     */
    #[ORM\OneToMany(targetEntity: Peres::class, mappedBy: 'profession')]
    private Collection $peres;

    /**
     * @var Collection<int, Meres>
     */
    #[ORM\OneToMany(targetEntity: Meres::class, mappedBy: 'profession')]
    private Collection $meres;

    public function __construct()
    {
        $this->peres = new ArrayCollection();
        $this->meres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        // Nettoyer les espaces et convertir en majuscules
        $this->designation = mb_strtoupper(trim($designation), 'UTF-8');
    
        return $this;
    }
    public function __toString(): string
    {
        return $this->designation ?? '';
    }

    /**
     * @return Collection<int, Peres>
     */
    public function getPeres(): Collection
    {
        return $this->peres;
    }

    public function addPere(Peres $pere): static
    {
        if (!$this->peres->contains($pere)) {
            $this->peres->add($pere);
            $pere->setProfession($this);
        }

        return $this;
    }

    public function removePere(Peres $pere): static
    {
        if ($this->peres->removeElement($pere)) {
            // set the owning side to null (unless already changed)
            if ($pere->getProfession() === $this) {
                $pere->setProfession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Meres>
     */
    public function getMeres(): Collection
    {
        return $this->meres;
    }

    public function addMere(Meres $mere): static
    {
        if (!$this->meres->contains($mere)) {
            $this->meres->add($mere);
            $mere->setProfession($this);
        }

        return $this;
    }

    public function removeMere(Meres $mere): static
    {
        if ($this->meres->removeElement($mere)) {
            // set the owning side to null (unless already changed)
            if ($mere->getProfession() === $this) {
                $mere->setProfession(null);
            }
        }

        return $this;
    }
}

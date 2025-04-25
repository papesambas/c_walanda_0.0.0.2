<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\RegionsRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Trait\SlugTrait;

#[ORM\Entity(repositoryClass: RegionsRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_REGION', fields: ['designation'])]
#[UniqueEntity(fields: ['designation'], message: "cette région n'est pas disponible")]
#[ORM\Table(name: 'regions')]
#[ORM\Index(name: 'idx_regions_designation', columns: ['designation'])]

class Regions
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank(message: 'La région ne peut pas être vide')]
    #[Assert\NotNull(message: 'La région ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 2,
        max: 60,
        minMessage: "La région doit avoir au moins {{ limit }} caractères.",
        maxMessage: "La région ne peut dépasser {{ limit }} caractères."
    )]
    private ?string $designation = null;

    /**
     * @var Collection<int, Cercles>
     */
    #[ORM\OneToMany(targetEntity: Cercles::class, mappedBy: 'region')]
    private Collection $cercles;

    public function __construct()
    {
        $this->cercles = new ArrayCollection();
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

    /**
     * @return Collection<int, Cercles>
     */
    public function getCercles(): Collection
    {
        return $this->cercles;
    }

    public function addCercle(Cercles $cercle): static
    {
        if (!$this->cercles->contains($cercle)) {
            $this->cercles->add($cercle);
            $cercle->setRegion($this);
        }

        return $this;
    }

    public function removeCercle(Cercles $cercle): static
    {
        if ($this->cercles->removeElement($cercle)) {
            // set the owning side to null (unless already changed)
            if ($cercle->getRegion() === $this) {
                $cercle->setRegion(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation;
    }
}

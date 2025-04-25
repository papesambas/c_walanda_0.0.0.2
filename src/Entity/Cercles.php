<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\CerclesRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CerclesRepository::class)]
#[ORM\Table(name: 'cercles')]
#[ORM\Index(name: 'idx_cercles_designation', columns: ['designation'])]
#[ORM\Index(name: 'idx_cercles_commune', columns: ['region_id'])]
class Cercles
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 130)]
    #[Assert\NotBlank(message: 'Le cercle ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le cercle ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 2,
        max: 130,
        minMessage: "Le cercle doit avoir au moins {{ limit }} caractères.",
        maxMessage: "Le cercle ne peut dépasser {{ limit }} caractères."
    )]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'cercles')]
    #[ORM\JoinColumn(name: 'region_id', nullable: false)] 
    #[Assert\NotBlank(message: 'La région ne peut pas être vide')]
    #[Assert\NotNull(message: 'La région ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getRegion() !== null",
        message: 'La région ne peut pas être vide'
    )]
    private ?Regions $region = null;

    /**
     * @var Collection<int, Communes>
     */
    #[ORM\OneToMany(targetEntity: Communes::class, mappedBy: 'cercle')]
    private Collection $communes;

    public function __construct()
    {
        $this->communes = new ArrayCollection();
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
        // 1. Supprimer les espaces avant/après
        $designation = trim($designation);

        // 2. Tout mettre en minuscules
        $lowercase = mb_strtolower($designation, 'UTF-8');

        // 3. Mettre en majuscule après les espaces, apostrophes et traits d'union
        $formatted = preg_replace_callback(
            '/(?:^|([\s\'-]))\p{Ll}/u',
            function ($matches) {
                if (isset($matches[1])) {
                    // Après un séparateur -> majuscule
                    return $matches[1] . mb_strtoupper($matches[0][1], 'UTF-8');
                } else {
                    // Début du texte -> majuscule
                    return mb_strtoupper($matches[0], 'UTF-8');
                }
            },
            $lowercase
        );

        $this->designation = $formatted;

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->region;
    }

    public function setRegion(?Regions $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Communes>
     */
    public function getCommunes(): Collection
    {
        return $this->communes;
    }

    public function addCommune(Communes $commune): static
    {
        if (!$this->communes->contains($commune)) {
            $this->communes->add($commune);
            $commune->setCercle($this);
        }

        return $this;
    }

    public function removeCommune(Communes $commune): static
    {
        if ($this->communes->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getCercle() === $this) {
                $commune->setCercle(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation;
    }
}

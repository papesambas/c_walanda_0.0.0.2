<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\PrenomsRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PrenomsRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_PRENOM', fields: ['designation'])]
#[UniqueEntity(fields: ['designation'], message: "ce nom d'utilisateur est pas disponible")]
#[ORM\Table(name: 'prenoms')]
#[ORM\Index(name: 'idx_prenoms_designation', columns: ['designation'])]
class Prenoms
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank(message: 'Le prénom ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le prénom ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: "Le prénom doit avoir au moins {{ limit }} caractères.",
        maxMessage: "Le prénom ne peut dépasser {{ limit }} caractères."
    )]

    private ?string $designation = null;

    /**
     * @var Collection<int, Peres>
     */
    #[ORM\OneToMany(targetEntity: Peres::class, mappedBy: 'prenom')]
    private Collection $peres;

    /**
     * @var Collection<int, Meres>
     */
    #[ORM\OneToMany(targetEntity: Meres::class, mappedBy: 'prenom')]
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
    public function __toString(): string
    {
        return $this->designation;
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
            $pere->setPrenom($this);
        }

        return $this;
    }

    public function removePere(Peres $pere): static
    {
        if ($this->peres->removeElement($pere)) {
            // set the owning side to null (unless already changed)
            if ($pere->getPrenom() === $this) {
                $pere->setPrenom(null);
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
            $mere->setPrenom($this);
        }

        return $this;
    }

    public function removeMere(Meres $mere): static
    {
        if ($this->meres->removeElement($mere)) {
            // set the owning side to null (unless already changed)
            if ($mere->getPrenom() === $this) {
                $mere->setPrenom(null);
            }
        }

        return $this;
    }
}

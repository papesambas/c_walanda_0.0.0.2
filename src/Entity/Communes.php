<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\CommunesRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommunesRepository::class)]
#[ORM\Table(name: 'communes')]
#[ORM\Index(name: 'idx_communes_designation', columns: ['designation'])]
#[ORM\Index(name: 'idx_communes_commune', columns: ['cercle_id'])]
class Communes
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 130)]
    #[Assert\NotBlank(message: 'La commune ne peut pas être vide')]
    #[Assert\NotNull(message: 'La commune ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s'-]+$/u",
        message: "Seules les lettres, espaces, apostrophes et tirets sont autorisés",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 2,
        max: 130,
        minMessage: "La commune doit avoir au moins {{ limit }} caractères.",
        maxMessage: "La commune ne peut dépasser {{ limit }} caractères."
    )]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'communes')]
    #[ORM\JoinColumn(name: 'cercle_id',nullable: false)]
    #[Assert\NotBlank(message: 'Le cercle ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le cercle ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getCercle() !== null",
        message: 'Le cercle ne peut pas être vide'
    )]
    private ?Cercles $cercle = null;

    /**
     * @var Collection<int, LieuNaissances>
     */
    #[ORM\OneToMany(targetEntity: LieuNaissances::class, mappedBy: 'commune')]
    private Collection $lieuNaissances;

    public function __construct()
    {
        $this->lieuNaissances = new ArrayCollection();
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
        return $this->designation ?? '';
    }

    public function getCercle(): ?Cercles
    {
        return $this->cercle;
    }

    public function setCercle(?Cercles $cercle): static
    {
        $this->cercle = $cercle;

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection<int, LieuNaissances>
     */
    public function getLieuNaissances(): Collection
    {
        return $this->lieuNaissances;
    }

    public function addLieuNaissance(LieuNaissances $lieuNaissance): static
    {
        if (!$this->lieuNaissances->contains($lieuNaissance)) {
            $this->lieuNaissances->add($lieuNaissance);
            $lieuNaissance->setCommune($this);
        }

        return $this;
    }

    public function removeLieuNaissance(LieuNaissances $lieuNaissance): static
    {
        if ($this->lieuNaissances->removeElement($lieuNaissance)) {
            // set the owning side to null (unless already changed)
            if ($lieuNaissance->getCommune() === $this) {
                $lieuNaissance->setCommune(null);
            }
        }

        return $this;
    }

}

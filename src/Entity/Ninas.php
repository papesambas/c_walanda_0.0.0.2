<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NinasRepository;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: NinasRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NINA', fields: ['numero'])]
#[UniqueEntity(fields: ['numero'], message: "Ce numéro NINA n'est pas disponible")]
#[ORM\Table(name: 'ninas')]
#[ORM\Index(name: 'idx_ninas_numero', columns: ['numero'])]

class Ninas
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'Le numéro NINA ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le numéro NINA ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^(?=(?:\d*[A-Za-z]){0,4}\d*$)(?=(?:\D*\d){9})[A-Za-z0-9]{13} [A-Za-z]$/",
        message: "Le numéro NINA doit contenir exactement 15 caractères.",
        normalizer: 'trim'
    )]
    #[Assert\Length(
        min: 15,
        max: 15,
        minMessage: "Le numéro NINA doit avoir exactement {{ limit }} chiffres.",
        maxMessage: "Le numéro NINA doit avoir exactement {{ limit }} chiffres."
    )]
    private ?string $numero = null;

    #[ORM\OneToOne(targetEntity: Peres::class, mappedBy: 'nina', cascade: ['persist', 'remove'])]
    private ?Peres $peres = null;

    #[ORM\OneToOne(targetEntity: Meres::class, mappedBy: 'nina', cascade: ['persist', 'remove'])]
    private ?Meres $meres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        // Nettoyer les espaces et convertir en majuscules
        $this->numero = mb_strtoupper(trim($numero), 'UTF-8');
    
        return $this;
    }

    public function __toString(): string
    {
        return $this->numero;
    }

    public function getPeres(): ?Peres
    {
        return $this->peres;
    }

    public function setPeres(?Peres $peres): static
    {
        // unset the owning side of the relation if necessary
        if ($peres === null && $this->peres !== null) {
            $this->peres->setNina(null);
        }

        // set the owning side of the relation if necessary
        if ($peres !== null && $peres->getNina() !== $this) {
            $peres->setNina($this);
        }

        $this->peres = $peres;

        return $this;
    }

    public function getMeres(): ?Meres
    {
        return $this->meres;
    }

    public function setMeres(?Meres $meres): static
    {
        // unset the owning side of the relation if necessary
        if ($meres === null && $this->meres !== null) {
            $this->meres->setNina(null);
        }

        // set the owning side of the relation if necessary
        if ($meres !== null && $meres->getNina() !== $this) {
            $meres->setNina($this);
        }

        $this->meres = $meres;

        return $this;
    }
}

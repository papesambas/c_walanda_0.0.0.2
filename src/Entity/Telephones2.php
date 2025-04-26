<?php

namespace App\Entity;

use App\Repository\Telephones2Repository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Entity\Trait\SlugTrait;

#[ORM\Entity(repositoryClass: Telephones2Repository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NUMERO', fields: ['numero'])]
#[UniqueEntity(fields: ['numero'], message: "Ce numéro de Téléphone existe déjà")]
#[ORM\Table(name: 'telephones2')]

class Telephones2
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le numéro ne peut pas être vide')]
    #[Assert\NotNull(message: 'Le numéro ne peut pas être nul')]
    #[Assert\Regex(
        pattern: "/^(?:(?:\+|00)223|0)[1-9]([\s.-]*\d{2}){4}$/",
        message: "Format invalide. Ex: 88585858, 23 45 67 89, +233 23 45 67 89"
    )]
    #[Assert\Length(
        min: 8,
        max: 20,
        minMessage: "Le numéro doit contenir au moins 8 caractères",
        maxMessage: "Le numéro ne peut dépasser 20 caractères"
    )]
    private ?string $numero = null;

    #[ORM\OneToOne(targetEntity: Peres::class, mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
    private ?Peres $peres = null;

    #[ORM\OneToOne(targetEntity: Meres::class, mappedBy: 'telephone2', cascade: ['persist', 'remove'])]
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
        // Normalisation: supprime tous les caractères non numériques sauf le +
        $numero = preg_replace('/[^0-9+]/', '', $numero);
        $this->numero = $numero;

        return $this;
    }
    public function __toString(): string
    {
        return $this->numero ?? '';
    }

    public function getPeres(): ?Peres
    {
        return $this->peres;
    }

    public function setPeres(?Peres $peres): static
    {
        // unset the owning side of the relation if necessary
        if ($peres === null && $this->peres !== null) {
            $this->peres->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($peres !== null && $peres->getTelephone2() !== $this) {
            $peres->setTelephone2($this);
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
            $this->meres->setTelephone2(null);
        }

        // set the owning side of the relation if necessary
        if ($meres !== null && $meres->getTelephone2() !== $this) {
            $meres->setTelephone2($this);
        }

        $this->meres = $meres;

        return $this;
    }
}
<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\EntityTrackingTrait;
use App\Repository\LieuNaissancesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LieuNaissancesRepository::class)]
#[ORM\Table(name: 'lieu_naissances')]
#[ORM\Index(name: 'idx_lieu_naissances_designation', columns: ['designation'])]
#[ORM\Index(name: 'idx_lieu_naissances_commune', columns: ['commune_id'])]
class LieuNaissances
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 130)]
    private ?string $designation = null;

    #[ORM\ManyToOne(inversedBy: 'lieuNaissances')]
    #[ORM\JoinColumn(name: 'commune_id',nullable: false)]
    #[Assert\NotBlank(message: 'La commune ne peut pas être vide')]
    #[Assert\NotNull(message: 'La commune ne peut pas être nul')]
    #[Assert\Valid]
    #[Assert\Expression(
        "this.getCommune() !== null",
        message: 'La commune ne peut pas être vide'
    )]
    private ?Communes $commune = null;

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
        $this->designation = $designation;

        return $this;
    }

    public function getCommune(): ?Communes
    {
        return $this->commune;
    }

    public function setCommune(?Communes $commune): static
    {
        $this->commune = $commune;

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation ?? '';
    }
}

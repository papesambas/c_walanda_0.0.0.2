<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ParentsRepository;
use App\Entity\Trait\EntityTrackingTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParentsRepository::class)]
#[ORM\Table(name: 'parents')]
#[ORM\Index(name: 'idx_parents_pere', columns: ['pere_id'])]
#[ORM\Index(name: 'idx_parents_mere', columns: ['mere_id'])]
#[ORM\Index(name: 'idx_parents_fullname', columns: ['fullname'])]
#[ORM\Index(name: 'idx_parents_user', columns: ['user_id'])]
class Parents
{
    use CreatedAtTrait;
    use EntityTrackingTrait;
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Peres::class,inversedBy: 'parents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    private ?Peres $pere = null;

    #[ORM\ManyToOne(targetEntity: Meres::class, inversedBy: 'parents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    
    private ?Meres $mere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fullname = null;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'parents')]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPere(): ?Peres
    {
        return $this->pere;
    }

    public function setPere(?Peres $pere): static
    {
        $this->pere = $pere;

        return $this;
    }

    public function getMere(): ?Meres
    {
        return $this->mere;
    }

    public function setMere(?Meres $mere): static
    {
        $this->mere = $mere;

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
    public function __toString(): string
    {
        return $this->fullname ?? '';
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}

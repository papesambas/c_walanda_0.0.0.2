<?php

namespace App\EventListener;

use App\Entity\Cercles;
use LogicException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class CerclesEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Cercles $cercles, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $cercles
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($cercles));
        }else{
            $cercles
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($cercles));
        }
    }

    public function preUpdate(Cercles $cercles, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $cercles
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($cercles));
        }else{
            $cercles
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($cercles));
        }
    }


    private function getClassesSlug(Cercles $cercles): string
    {
        $slug = mb_strtolower($cercles->getDesignation() . '-' . $cercles->getId() . '-' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }
}

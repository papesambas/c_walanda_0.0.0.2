<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Prenoms;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class PrenomsEntityListener
{
    private $Securty;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Securty = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Prenoms $prenom, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $prenom
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($prenom));
        }else{
            $prenom
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setCreatedBy($user)
            ->setSlug($this->getClassesSlug($prenom));
        }
    }

    public function preUpdate(Prenoms $prenom, LifecycleEventArgs $arg): void
    {
        $user = $this->Securty->getUser();
        if ($user === null) {
            $prenom
            ->setDesignation($this->getPrenom($prenom))
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($prenom));
        }else{
            $prenom
            ->setDesignation($this->getPrenom($prenom))
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setUpdatedBy($user)
            ->setSlug($this->getClassesSlug($prenom));
        }
    }


    private function getClassesSlug(Prenoms $prenom): string
    {
        $slug = mb_strtolower($prenom->getDesignation() . '-' . $prenom->getId() . '' . time(), 'UTF-8');
        return $this->Slugger->slug($slug);
    }

    private function getPrenom(Prenoms $prenoms): string
    {
        // Convertir le prénom en minuscules puis mettre la première lettre en majuscule
        $prenom = ucfirst(mb_strtolower($prenoms->getDesignation(), 'UTF-8'));
        // Convertir le nom en majuscules
        return $prenom;
    }

}

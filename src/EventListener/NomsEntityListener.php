<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Noms;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class NomsEntityListener
{
    private $security;
    private $slugger;
    private $tokenStorage;

    public function __construct(Security $security, SluggerInterface $slugger, TokenStorageInterface $tokenStorage)
    {
        $this->security = $security;
        $this->slugger = $slugger;
        $this->tokenStorage = $tokenStorage;
    }

    public function prePersist(Noms $nom, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nom->setCreatedAt(new \DateTimeImmutable('now'))
            ->setDesignation($this->getNom($nom))
            ->setSlug($this->getClassesSlug($nom));

        if ($user) {
            $nom->setCreatedBy($user);
        }
    }

    public function preUpdate(Noms $nom, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nom->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setDesignation($this->getNom($nom))
            ->setSlug($this->getClassesSlug($nom));

        if ($user) {
            $nom->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Noms $nom): string
    {
        $slug = mb_strtolower($nom->getDesignation() . '' . $nom->getId(), 'UTF-8');
        return $this->slugger->slug($slug)->toString();
    }

    private function getNom(Noms $noms): string
    {
        // Convertir le nom en majuscules
        $nom = mb_strtoupper($noms->getDesignation(), 'UTF-8');

        // Concaténer avec un tiret (ou un espace, selon vos préférences)
        //$fullName = $prenom . ' ' . $nom;

        // Optionnel : Si vous souhaitez utiliser un slugger pour traiter les accents ou autres caractères,
        // assurez-vous que le slugger ne modifie pas le casing. 
        // Par exemple, si vous utilisez le SluggerInterface de Symfony, par défaut il renvoie tout en minuscules.
        // Dans ce cas, vous pouvez soit ne pas l'utiliser, soit configurer vos options pour préserver la casse.
        // return $this->slugger->slug($fullName, ' ')->toString(); // Cela risque de tout mettre en minuscules par défaut.

        return $nom;
    }
}

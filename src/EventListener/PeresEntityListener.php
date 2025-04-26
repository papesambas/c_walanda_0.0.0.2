<?php

namespace App\EventListener;

use App\Entity\Peres;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class PeresEntityListener
{
    private $security;
    private $slugger;

    public function __construct(Security $security, SluggerInterface $slugger)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public function prePersist(Peres $peres, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');

        // Ajout de la date de création et du slug
        $peres->setCreatedAt($currentTime)
            ->setFullname($this->getFullName($peres))
            ->setSlug($this->getPereSlug($peres));

        if ($user) {
            $peres->setCreatedBy($user);
        }

    }

    public function preUpdate(Peres $peres, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');

        // Mise à jour de la date et du slug
        $peres->setUpdatedAt($currentTime)
            ->setFullname($this->getFullName($peres))
            ->setSlug($this->getPereSlug($peres));

        if ($user) {
            $peres->setUpdatedBy($user);
        }

    }

    private function getPereSlug(Peres $peres): string
    {
        $slug = mb_strtolower($peres->getNom() . '-' . $peres->getPrenom() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function getFullName(Peres $peres): string
    {
        // Convertir le prénom en minuscules puis mettre la première lettre en majuscule
        $prenom = ucfirst(mb_strtolower($peres->getPrenom(), 'UTF-8'));
        // Convertir le nom en majuscules
        $nom = mb_strtoupper($peres->getNom(), 'UTF-8');

        // Concaténer avec un tiret (ou un espace, selon vos préférences)
        $fullName = $prenom . ' ' . $nom;

        // Optionnel : Si vous souhaitez utiliser un slugger pour traiter les accents ou autres caractères,
        // assurez-vous que le slugger ne modifie pas le casing. 
        // Par exemple, si vous utilisez le SluggerInterface de Symfony, par défaut il renvoie tout en minuscules.
        // Dans ce cas, vous pouvez soit ne pas l'utiliser, soit configurer vos options pour préserver la casse.
        // return $this->slugger->slug($fullName, ' ')->toString(); // Cela risque de tout mettre en minuscules par défaut.

        return $fullName;
    }

}

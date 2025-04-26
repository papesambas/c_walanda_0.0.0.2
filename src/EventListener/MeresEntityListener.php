<?php

namespace App\EventListener;

use App\Entity\Meres;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class MeresEntityListener
{
    private $security;
    private $slugger;

    public function __construct(Security $security, SluggerInterface $slugger)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public function prePersist(Meres $meres, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');

        // Ajout de la date de création et du slug
        $meres->setCreatedAt($currentTime)
            ->setFullname($this->getFullName($meres))
            ->setSlug($this->getMereSlug($meres));

        if ($user) {
            $meres->setCreatedBy($user);
        }

    }

    public function preUpdate(Meres $meres, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        $currentTime = new \DateTimeImmutable('now');

        // Mise à jour de la date et du slug
        $meres->setUpdatedAt($currentTime)
            ->setFullname($this->getFullName($meres))
            ->setSlug($this->getMereSlug($meres));

        if ($user) {
            $meres->setUpdatedBy($user);
        }

    }

    private function getMereSlug(Meres $meres): string
    {
        $slug = mb_strtolower($meres->getNom() . '-' . $meres->getPrenom() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }

    private function getFullName(Meres $meres): string
    {
        // Convertir le prénom en minuscules puis mettre la première lettre en majuscule
        $prenom = ucfirst(mb_strtolower($meres->getPrenom(), 'UTF-8'));
        // Convertir le nom en majuscules
        $nom = mb_strtoupper($meres->getNom(), 'UTF-8');

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

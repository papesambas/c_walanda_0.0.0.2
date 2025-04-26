<?php

namespace App\EventListener;

use App\Entity\Parents;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

class ParentsEntityListener
{
    private $Security;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Security = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(Parents $parents, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $parents->setCreatedAt(new \DateTimeImmutable('now'))
            ->setFullname($this->getFullName($parents))
            ->setSlug($this->getClassesSlug($parents, $arg));

        if ($user !== null) {
            $parents->setCreatedBy($user);
        }
    }

    public function preUpdate(Parents $parents, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $parents->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setFullname($this->getFullName($parents))
            ->setSlug($this->getClassesSlug($parents, $arg));

        if ($user !== null) {
            $parents->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Parents $parents, LifecycleEventArgs $args): string
    {
        // Récupère le repository des Parents pour vérifier l'unicité
        $repository = $args->getObjectManager()->getRepository(Parents::class);

        // Base du slug sans ID (car l'ID n'est pas encore défini lors du prePersist)
        $baseSlug = mb_strtolower($parents->getPere() . '-' . $parents->getMere(), 'UTF-8');
        $slug = $this->Slugger->slug($baseSlug)->toString();

        // Vérifie si le slug existe déjà dans la base de données
        $counter = 1;
        $uniqueSlug = $slug;

        // Si le slug existe déjà, ajoute un suffixe incrémental
        while ($repository->findOneBy(['slug' => $uniqueSlug])) {
            $uniqueSlug = $slug . '-' . $counter;
            $counter++;
        }

        return $uniqueSlug;
    }

    private function getFullName(Parents $parent): string
    {
        // Convertir le prénom en minuscules puis mettre la première lettre en majuscule
        $prenomPere = ucfirst(mb_strtolower($parent->getPere()->getPrenom(), 'UTF-8'));
        $prenomMere = ucfirst(mb_strtolower($parent->getMere()->getPrenom(), 'UTF-8'));

        // Convertir le nom en majuscules
        $nomPere = mb_strtoupper($parent->getPere()->getNom(), 'UTF-8');
        $nomMere = mb_strtoupper($parent->getMere()->getNom(), 'UTF-8');

        // Concaténer avec un tiret (ou un espace, selon vos préférences)
        $fullName = $prenomPere . ' ' . $nomPere . ' & ' . $prenomMere . ' ' . $nomMere;

        // Optionnel : Si vous souhaitez utiliser un slugger pour traiter les accents ou autres caractères,
        // assurez-vous que le slugger ne modifie pas le casing. 
        // Par exemple, si vous utilisez le SluggerInterface de Symfony, par défaut il renvoie tout en minuscules.
        // Dans ce cas, vous pouvez soit ne pas l'utiliser, soit configurer vos options pour préserver la casse.
        // return $this->slugger->slug($fullName, ' ')->toString(); // Cela risque de tout mettre en minuscules par défaut.

        return $fullName;
    }
}

<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Users;
use App\Entity\StatutEleves;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersEntityListener
{
    private $security;
    private $slugger;

    public function __construct(Security $security, SluggerInterface $slugger)
    {
        $this->security = $security;
        $this->slugger = $slugger;
    }

    public function prePersist(Users $users, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        if ($user === null) {
            $users
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($users));
        }else{
            $users
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($users));
        }
    }

    public function preUpdate(Users $users, LifecycleEventArgs $arg): void
    {
        $user = $this->security->getUser();
        if ($user === null) {
            $users
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($users));
        }else{
            $users
            ->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($users));
        }
    }


    private function getClassesSlug(Users $users): string
    {
        $slug = mb_strtolower($users->getUsername() . '-' . $users->getId() . '-' . time(), 'UTF-8');
        return $this->slugger->slug($slug);
    }
}

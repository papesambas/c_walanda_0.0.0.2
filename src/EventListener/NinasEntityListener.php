<?php

namespace App\EventListener;

use LogicException;
use App\Entity\Ninas;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class NinasEntityListener
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

    public function prePersist(Ninas $nina, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nina->setCreatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($nina));

        if ($user) {
            $nina->setCreatedBy($user);
        }
    }

    public function preUpdate(Ninas $nina, LifecycleEventArgs $arg): void
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $nina->setUpdatedAt(new \DateTimeImmutable('now'))
            ->setSlug($this->getClassesSlug($nina));

        if ($user) {
            $nina->setUpdatedBy($user);
        }
    }

    private function getClassesSlug(Ninas $nina): string
    {
        $slug = mb_strtolower($nina->getNumero() . '' . $nina->getId() , 'UTF-8');
        return $this->slugger->slug($slug)->toString();
    }
}

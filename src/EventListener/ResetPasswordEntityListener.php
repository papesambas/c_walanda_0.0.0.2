<?php

namespace App\EventListener;

use App\Entity\ResetPasswordRequest;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ResetPasswordEntityListener
{
    private $Security;
    private $Slugger;

    public function __construct(Security $security, SluggerInterface $Slugger)
    {
        $this->Security = $security;
        $this->Slugger = $Slugger;
    }

    public function prePersist(ResetPasswordRequest $reset, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $reset->setCreatedAt(new \DateTimeImmutable('now'));

        if ($user !== null) {
            $reset->setCreatedBy($user);
        }
    }

    public function preUpdate(ResetPasswordRequest $reset, LifecycleEventArgs $arg): void
    {
        $user = $this->Security->getUser();
        $reset->setCreatedAt(new \DateTimeImmutable('now'));
        $reset->setUpdatedAt(new \DateTimeImmutable('now'));

        if ($user !== null) {
            $reset->setUpdatedBy($user);
            $reset->setCreatedBy($user);
        }
    }

}

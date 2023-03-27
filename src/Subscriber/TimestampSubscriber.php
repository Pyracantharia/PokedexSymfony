<?php

namespace App\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TimestampSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if(method_exists($entity, 'setCreatedAt') && method_exists($entity, 'setUpdatedAt')) {
           $entity->setCreatedAt(new \DateTime());
           $entity->setUpdatedAt(new \DateTime());
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if(method_exists($entity, 'setUpdatedAt')) {
           $entity->setUpdatedAt(new \DateTime());
        }
    }
}
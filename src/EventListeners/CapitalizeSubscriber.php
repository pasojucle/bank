<?php

namespace App\EventListeners;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use ReflectionClass;

class CapitalizeSubscriber implements EventSubscriberInterface
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postLoad,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->toLowerCase($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->toLowerCase($args);
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $this->capitalize($args);
    }

    private function capitalize(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $reflexionClass = new ReflectionClass($entity);
        if ($reflexionClass->hasProperty('name')) {
            $name = mb_convert_case(ucfirst($entity->getName()), MB_CASE_TITLE, 'UTF-8');
            $entity->setName($name);
        }
    }

    private function toLowerCase(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $reflexionClass = new ReflectionClass($entity);
        if ($reflexionClass->hasProperty('name')) {
            $name = mb_convert_case($entity->getName(), MB_CASE_LOWER, 'UTF-8');
            $entity->setName($name);
        }
    }
}
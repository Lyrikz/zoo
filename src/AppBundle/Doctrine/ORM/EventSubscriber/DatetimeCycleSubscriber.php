<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\EventSubscriber;

use AppBundle\Doctrine\ORM\Extension\DatetimeCycleInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class DatetimeCycleSubscriber.
 */
class DatetimeCycleSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof DatetimeCycleInterface) {
            return;
        }

        $now = new \DateTime('now');
        $entity->setCreatedAt($now);
        $entity->setUpdatedAt($now);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!$entity instanceof DatetimeCycleInterface) {
            return;
        }

        $now = new \DateTime('now');
        $entity->setUpdatedAt($now);
    }
}

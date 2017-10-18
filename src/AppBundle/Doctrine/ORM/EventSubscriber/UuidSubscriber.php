<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\EventSubscriber;

use AppBundle\Doctrine\ORM\Extension\UuidInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class UuidSubscriber.
 */
class UuidSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
        ];
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if (!$entity instanceof UuidInterface) {
            return;
        }

        $conn = $event->getEntityManager()->getConnection();
        $sql = 'SELECT '.$conn->getDatabasePlatform()->getGuidExpression();

        $uuid = $conn->query($sql)->fetchColumn(0);

        $entity->setUuid($uuid);
    }
}

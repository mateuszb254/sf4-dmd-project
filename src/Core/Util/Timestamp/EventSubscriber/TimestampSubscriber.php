<?php

namespace App\Core\Util\Timestamp\EventSubscriber;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;


final class TimestampSubscriber implements EventSubscriber
{
    public function prePersist(LifecycleEventArgs $event)
    {
        $object = $event->getObject();

        if (!$this->isSupported(get_class($object))) {
            return;
        }

        $object->setCreatedAt(new \DateTime());
    }

    private function isSupported(string $className): bool
    {
        if (in_array(TimestampableTrait::class, class_uses($className))) return true;

        return false === get_parent_class($className) ? false : $this->isSupported(get_parent_class($className));
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }
}

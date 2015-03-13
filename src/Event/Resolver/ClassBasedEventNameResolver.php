<?php

/**
 * @license https://github.com/simple-es/event-sourcing/blob/master/LICENSE MIT
 */

namespace SimpleES\EventSourcing\Event\Resolver;

use SimpleES\EventSourcing\Event\DomainEvent;

/**
 * @copyright Copyright (c) 2015 Future500 B.V.
 * @author    Jasper N. Brouwer <jasper@future500.nl>
 */
class ClassBasedEventNameResolver implements ResolvesEventNames
{
    /**
     * {@inheritdoc}
     */
    public function resolveEventName(DomainEvent $event)
    {
        return get_class($event);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveEventClass($name)
    {
        return $name;
    }
}

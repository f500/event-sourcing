<?php

/**
 * @license https://github.com/simple-es/event-sourcing/blob/master/LICENSE MIT
 */

namespace SimpleES\EventSourcing\Collection;

use SimpleES\EventSourcing\Event\SerializableEvent;
use SimpleES\EventSourcing\Exception\CollectionIsEmpty;
use SimpleES\EventSourcing\Exception\InvalidItemInCollection;

/**
 * @copyright Copyright (c) 2015 Future500 B.V.
 * @author    Jasper N. Brouwer <jasper@future500.nl>
 */
final class EventStream extends Collection
{
    /**
     * {@inheritdoc}
     */
    protected function guardItem($item)
    {
        if (!($item instanceof SerializableEvent)) {
            throw InvalidItemInCollection::create($item, 'SimpleES\EventSourcing\Event\SerializableEvent');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function guardAmountOfItems($amount)
    {
        if ($amount === 0) {
            throw CollectionIsEmpty::create();
        }
    }
}

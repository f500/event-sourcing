<?php

/**
 * @license https://github.com/simple-es/event-sourcing/blob/master/LICENSE MIT
 */

namespace SimpleES\EventSourcing\Test\Examples;

use SimpleES\EventSourcing\Event\NameResolver\MappingEventNameResolver;
use SimpleES\EventSourcing\Example\Basket\BasketId;
use SimpleES\EventSourcing\Example\Basket\Events\BasketWasPickedUp;
use SimpleES\EventSourcing\Example\Basket\Events\ProductWasAddedToBasket;
use SimpleES\EventSourcing\Example\Basket\Events\ProductWasRemovedFromBasket;
use SimpleES\EventSourcing\Example\Product\ProductId;

/**
 * @copyright Copyright (c) 2015 Future500 B.V.
 * @author    Jasper N. Brouwer <jasper@future500.nl>
 */
class MappingEventNameResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MappingEventNameResolver
     */
    private $eventNameResolver;

    public function setUp()
    {
        $ns = 'SimpleES\EventSourcing\Example\Basket\Events';

        $this->eventNameResolver = new MappingEventNameResolver(
            [
                $ns . '\BasketWasPickedUp'           => 'basket_was_picked_up',
                $ns . '\ProductWasAddedToBasket'     => 'product_was_added_to_basket',
                $ns . '\ProductWasRemovedFromBasket' => 'product_was_removed_from_basket',
            ]
        );
    }

    public function tearDown()
    {
        $this->eventNameResolver = null;
    }

    /**
     * @test
     */
    public function itResolvesEventNames()
    {
        $basketId  = BasketId::fromString('some-basket');
        $productId = ProductId::fromString('some-product');

        $this->assertSame(
            'basket_was_picked_up',
            $this->eventNameResolver->resolveEventName(new BasketWasPickedUp($basketId))
        );

        $this->assertSame(
            'product_was_added_to_basket',
            $this->eventNameResolver->resolveEventName(new ProductWasAddedToBasket($basketId, $productId))
        );

        $this->assertSame(
            'product_was_removed_from_basket',
            $this->eventNameResolver->resolveEventName(new ProductWasRemovedFromBasket($basketId, $productId))
        );
    }

    /**
     * @test
     * @expectedException \SimpleES\EventSourcing\Exception\MapNotFound
     */
    public function itCannotResolveAnEventNameThatIsNotMapped()
    {
        $event = $this->getMock('SimpleES\EventSourcing\Event\DomainEvent');

        $this->eventNameResolver->resolveEventName($event);
    }

    /**
     * @test
     */
    public function itResolvesEventClasses()
    {
        $this->assertSame(
            'SimpleES\EventSourcing\Example\Basket\Events\BasketWasPickedUp',
            $this->eventNameResolver->resolveEventClass('basket_was_picked_up')
        );

        $this->assertSame(
            'SimpleES\EventSourcing\Example\Basket\Events\ProductWasAddedToBasket',
            $this->eventNameResolver->resolveEventClass('product_was_added_to_basket')
        );

        $this->assertSame(
            'SimpleES\EventSourcing\Example\Basket\Events\ProductWasRemovedFromBasket',
            $this->eventNameResolver->resolveEventClass('product_was_removed_from_basket')
        );
    }

    /**
     * @test
     * @expectedException \SimpleES\EventSourcing\Exception\MapNotFound
     */
    public function itCannotResolveAnEventClassThatIsNotMapped()
    {
        $this->eventNameResolver->resolveEventClass('some_event');
    }
}

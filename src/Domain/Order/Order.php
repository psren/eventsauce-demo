<?php

declare(strict_types=1);

namespace Psren\EventsauceDemo\Domain\Order;


use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;

final class Order implements AggregateRoot
{
    use AggregateRootBehaviour;
    
    private $items = [];
    
    public function addItem(AddItem $command)
    {
        // Guard the event with businessrules here
        
        $this->recordThat(new ItemAdded(
            $command->getItem()->getId(),
            $command->getItem()->getName(),
            $command->getQuantity(),
            $command->getQuantity() * $command->getItem()->getUnitPrice()
        ));
    }
    
    private function applyItemAdded(ItemAdded $event)
    {
        $this->items[] = [
            'id' => $event->getId(),
            'quantity' => $event->getQuantity(),
            'total' => $event->getTotal(),
        ];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
    
    
}
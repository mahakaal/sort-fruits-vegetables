<?php

namespace App\Tests\App\Service;

use App\builder\GroceryBuilder;
use App\Model\GroceryItem;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class GroceryItemBuilderTest extends TestCase
{

    public function testCreateGroceryItem()
    {
        $builder = new GroceryBuilder();

        $data = [
            "id" => 777,
            "name" => "TEST",
            "type" => "fruit",
            "quantity" => 20830,
            "unit" => "g"
        ];

        $groceryItem = $builder->build($data);

        assertEquals(GroceryItem::class, get_class($groceryItem));
        assertEquals($data['id'], $groceryItem->getId());
        assertEquals($data['name'], $groceryItem->getName());
        assertEquals($data['type'], $groceryItem->getType());
        assertEquals($data['quantity'], $groceryItem->getQuantity());
        assertEquals($data['unit'], $groceryItem->getUnit());
    }
}
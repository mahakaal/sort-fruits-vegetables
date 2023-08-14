<?php

namespace App\Tests\App\Service;

use App\builder\GroceryBuilder;
use App\Model\GroceryItem;
use App\Service\GroceryService;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class GroceryServiceTest extends TestCase
{

    public function testCreateCollections(): void
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $this->assertNotEmpty($groceryService->getFruitsCollection()->list());
        $this->assertNotEmpty($groceryService->getVegetablesCollection()->list());
    }

    public function testCheckTotalItems(): void
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $items = json_decode(file_get_contents('request.json'), true);
        $fruits = $groceryService->getFruitsCollection();
        $vegetables = $groceryService->getVegetablesCollection();

        assertEquals(count($items), $fruits->length() + $vegetables->length());
        assertEquals(count(array_filter($items, fn ($item) => "fruit" === $item["type"])), $fruits->length());
        assertEquals(count(array_filter($items, fn ($item) => "vegetable" === $item["type"])), $vegetables->length());
    }

    public function testInsertFruit()
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $fruit = new GroceryItem();
        $fruit
            ->setId(77)
            ->setName("Test Fruit")
            ->setType("fruit")
            ->setUnit("g")
            ->setQuantity(1000);

        $groceryService->addElement($fruit);

        $added = $groceryService->searchElement($fruit->getName());
        assertEquals($fruit, $added);
    }

    public function testRemoveFruit()
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $fruit = new GroceryItem();
        $fruit
            ->setId(77)
            ->setName("Test Fruit")
            ->setType("fruit")
            ->setUnit("g")
            ->setQuantity(1000);

        $groceryService->addElement($fruit);

        $added = $groceryService->searchElement($fruit->getName());
        assertEquals($fruit, $added, "Added");

        $groceryService->removeElement($fruit);
        assertNull($groceryService->searchElement($fruit->getName()), "Removed successfully");
    }

    public function testIsGram()
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $fruit = new GroceryItem();
        $fruit
            ->setId(77)
            ->setName("Test Fruit")
            ->setType("fruit")
            ->setUnit("kg")
            ->setQuantity(1);

        $groceryService->addElement($fruit);

        $added = $groceryService->searchElement($fruit->getName());
        assertEquals(1000, $added->getQuantity());
        assertEquals("g", $added->getUnit());
    }

    public function testGetKiloGram()
    {
        $groceryService = new GroceryService(new GroceryBuilder());
        $groceryService->load('request.json');

        $fruit = new GroceryItem();
        $fruit
            ->setId(77)
            ->setName("Test Fruit")
            ->setType("fruit")
            ->setUnit("g")
            ->setQuantity(1000);

        $groceryService->addElement($fruit);

        $added = $groceryService->searchElement($fruit->getName(), "kg");
        assertEquals(1, $added->getQuantity());
        assertEquals("kg", $added->getUnit());
    }
}

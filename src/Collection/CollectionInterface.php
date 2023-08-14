<?php

namespace App\Collection;

use App\Model\GroceryItem;

interface CollectionInterface
{

    /**
     * @param GroceryItem $grocery
     * @return mixed
     */
    public function add(GroceryItem $grocery);

    /**
     * @param GroceryItem $grocery
     * @return mixed
     */
    public function remove(GroceryItem $grocery);

    /**
     * @param string $type
     * @return GroceryItem[]|array
     */
    public function list(string $type = 'g'): array;

    /**
     * @param string $name
     * @param string $unit
     * @return GroceryItem|null
     */
    public function search(string $name, string $unit = 'g'): ?GroceryItem;

    /**
     * @return int
     */
    public function length(): int;
}
<?php

namespace App\Collection;

use App\Model\GroceryItem;

class Collection implements CollectionInterface
{
    private array $data = [];

    /**
     * @inheritDoc
     */
    public function add(GroceryItem $grocery)
    {
        $this->data[] = $this->convertToGrams($grocery);
    }

    /**
     * @inheritDoc
     */
    public function remove(GroceryItem $grocery)
    {
        if ($id = $this->getElementId($grocery->getName())) {
            unset($this->data[$id]);
        }
    }

    /**
     * @param string $type
     * @inheritDoc
     */
    public function list(string $type = "g"): array
    {
        if ('kg' === $type) {
            return array_map(fn($item) => $this->convertToKg($item), $this->data);
        }

        return $this->data;
    }

    /**
     * @param string $name
     * @return int|null
     */
    protected function getElementId(string $name): ?int
    {
        $result = array_filter($this->data, fn(GroceryItem $object) => $name === $object->getName());
        return empty($result) ? null : array_key_first($result);
    }

    /**
     * @inheritDoc
     */
    public function length(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function search(string $name, string $unit = 'g'): ?GroceryItem
    {
        $result = $this->getElementId($name);
        if (empty($result)) return null;

        $item = $this->data[$result];
        if ("kg" === $unit) return $this->convertToKg($item);

        return $item;
    }

    /**
     * @param GroceryItem $item
     * @return GroceryItem
     */
    private function convertToKg(GroceryItem $item): GroceryItem
    {
        $item->setQuantity($item->getQuantity()/1000);
        $item->setUnit("kg");
        return $item;
    }

    /**
     * @param GroceryItem $item
     * @return GroceryItem
     */
    private function convertToGrams(GroceryItem $item): GroceryItem
    {
        if ("kg" === $item->getUnit()) {
            $item->setQuantity($item->getQuantity() * 1000);
            $item->setUnit("g");
        }
        return $item;
    }
}
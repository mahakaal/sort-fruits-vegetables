<?php

namespace App\Model;

class GroceryItem
{
    /** @var int */
    private int $id;

    /** @var string */
    private string $name;

    /** @var string */
    private string $type;

    /** @var int */
    private int $quantity;

    /** @var string */
    private string $unit;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return GroceryItem
     */
    public function setId(int $id): GroceryItem
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return GroceryItem
     */
    public function setName(string $name): GroceryItem
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return GroceryItem
     */
    public function setType(string $type): GroceryItem
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return GroceryItem
     */
    public function setQuantity(int $quantity): GroceryItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     * @return GroceryItem
     */
    public function setUnit(string $unit): GroceryItem
    {
        $this->unit = $unit;
        return $this;
    }
}
<?php

namespace App\Service;

use App\builder\GroceryBuilder;
use App\Collection\Collection;
use App\Model\GroceryItem;

class GroceryService
{
    /** @var StorageService  */
    protected StorageService $storageService;

    /** @var GroceryBuilder  */
    protected GroceryBuilder $groceryBuilder;

    /** @var Collection|null  */
    protected Collection|null $fruitsCollection = null;

    /** @var Collection|null  */
    protected Collection|null $vegetablesCollection = null;

    /**
     * @param GroceryBuilder $groceryBuilder
     */
    public function __construct(
        GroceryBuilder $groceryBuilder
    )
    {
        $this->groceryBuilder = $groceryBuilder;
    }

    /**
     * @param string $filename
     * @return GroceryService
     * @throws \Exception
     */
    private function loadData(string $filename): GroceryService
    {
        if (!file_exists($filename)) {
            throw new \Exception("Provided file does not exist.");
        }

        $this->storageService = new StorageService(file_get_contents($filename));
        return $this;
    }

    /**
     * @return GroceryService
     * @throws \Exception
     */
    private function populateCollections(): GroceryService
    {
        $data = json_decode($this->storageService->getRequest(), true);
        if (json_last_error()) {
            throw new \Exception(sprintf("Something went wrong while decoding %s JSON. ERROR: %s",
                $this->storageService->getRequest(),
                json_last_error_msg()
            ));
        }

        $fruitsData = array_filter($data, fn($d) => "fruit" === $d["type"]);
        $vegetablesData = array_filter($data, fn($d) => "vegetable" === $d["type"]);
        $this->fruitsCollection = $this->createCollection($fruitsData, new Collection());
        $this->vegetablesCollection = $this->createCollection($vegetablesData, new Collection());

        return $this;
    }

    /**
     * @param array $data
     * @param Collection $collection
     * @return Collection
     * @throws \Exception
     */
    private function createCollection(array $data, Collection $collection): Collection
    {
        foreach ($data as $item) {
            $grocery = $this->groceryBuilder->build($item);
            $collection->add($grocery);
        }

        return $collection;
    }

    /**
     * @param string $filename
     * @return void
     * @throws \Exception
     */
    public function load(string $filename): void
    {
        $this
            ->loadData($filename)
            ->populateCollections();
    }

    /**
     * @return Collection
     */
    public function getFruitsCollection(): Collection
    {
        return $this->fruitsCollection;
    }

    /**
     * @return Collection
     */
    public function getVegetablesCollection(): Collection
    {
        return $this->vegetablesCollection;
    }

    /**
     * @param GroceryItem $object
     * @return void
     */
    public function addElement(GroceryItem $object) {
        switch ($object->getType()) {
            case "fruit":
                $this->fruitsCollection->add($object);
                break;
            case "vegetable":
                $this->vegetablesCollection->add($object);
                break;
            default:
                break;
        }
    }

    /**
     * @param GroceryItem $object
     * @return void
     */
    public function removeElement(GroceryItem $object) {
        switch ($object->getType()) {
            case "fruit":
                $this->fruitsCollection->remove($object);
                break;
            case "vegetable":
                $this->vegetablesCollection->remove($object);
                break;
            default:
                break;
        }
    }

    /**
     * @param string $name
     * @param string $unit
     * @return GroceryItem|null
     */
    public function searchElement(string $name, string $unit = 'g'): ?GroceryItem
    {
        $result = $this->fruitsCollection->search($name, $unit);
        if (null !== $result) {
            return $result;
        }

        return $this->vegetablesCollection->search($name, $unit);
    }
}
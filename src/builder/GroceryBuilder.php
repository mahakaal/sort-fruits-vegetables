<?php

namespace App\builder;

use App\Model\GroceryItem;
use App\Resolver\GroceryOptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroceryBuilder
{
    /** @var OptionsResolver  */
    protected OptionsResolver $optionsResolver;

    public function __construct()
    {
        $this->optionsResolver = GroceryOptionsResolver::createResolver();
    }

    /**
     * @param array $groceryList
     * @return GroceryItem
     * @throws \Exception
     */
    public function build(array $groceryList): GroceryItem
    {
        if (!$this->optionsResolver->resolve($groceryList)) {
            throw new \Exception(sprintf("The array isn't valid: %s",
                implode("\n", $this->optionsResolver->getMissingOptions())
            ));
        }

        $grocery = new GroceryItem();
        foreach ($groceryList as $key => $value) {
            $setter = "set". ucfirst($key);
            if (method_exists($grocery, $setter)) {
                $grocery->$setter($value);
            }
        }

        return $grocery;
    }
}
<?php

namespace App\Resolver;

use Symfony\Component\OptionsResolver\OptionsResolver;

class GroceryOptionsResolver
{
    public static function createResolver()
    {
        $optionResolver = new OptionsResolver();
        $optionResolver
            ->define("id")
            ->required()
            ->allowedTypes("int");

        $optionResolver
            ->define("name")
            ->required()
            ->allowedTypes("string");

        $optionResolver
            ->define("type")
            ->required()
            ->allowedTypes("string")
            ->allowedValues("fruit", "vegetable");

        $optionResolver
            ->define("quantity")
            ->required()
            ->allowedTypes("int");

        $optionResolver
            ->define("unit")
            ->required()
            ->allowedTypes("string")
            ->allowedValues("g", "kg");

        return $optionResolver;
    }
}
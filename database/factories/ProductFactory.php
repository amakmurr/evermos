<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'price' => $faker->numberBetween(10000, 100000),
        'stock' => $faker->numberBetween(50, 100)
    ];
});

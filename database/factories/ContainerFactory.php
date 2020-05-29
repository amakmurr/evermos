<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Container;
use Faker\Generator as Faker;

$factory->define(Container::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'capacity' => $faker->numberBetween(5, 10),
        'value' => 0,
        'verified' => false
    ];
});

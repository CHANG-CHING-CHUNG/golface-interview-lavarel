<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Score::class, function (Faker $faker) {
    return [
        'player' => $faker->name,
        'value' => $faker->randomDigit
    ];
});

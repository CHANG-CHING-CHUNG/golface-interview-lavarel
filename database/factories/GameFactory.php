<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Game::class, function (Faker $faker) {
    return [
        'title' => 'April Fool\'s Day',
        'startAt' => 1585713660,
    ];
});


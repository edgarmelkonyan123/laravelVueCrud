<?php

use Faker\Generator as Faker;

$factory->define(App\Section::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'logo' => 'logo/default-logo.png',
    ];
});

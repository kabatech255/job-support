<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ActionType;
use Faker\Generator as Faker;

$factory->define(ActionType::class, function (Faker $faker) {
  return [
    'key' => $faker->unique()->word,
    'label_name' => $faker->word,
    'template_message' => $faker->sentence(2),
    'link' => '/',
  ];
});

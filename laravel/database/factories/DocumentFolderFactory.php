<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentFolder;
use Faker\Generator as Faker;

$factory->define(DocumentFolder::class, function (Faker $faker) {
  return [
    'name' => $faker->title,
    'created_by' => array_random(\App\Models\User::pluck('id')->toArray()),
  ];
});

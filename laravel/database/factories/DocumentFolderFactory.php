<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DocumentFolder;
use Faker\Generator as Faker;

$factory->define(DocumentFolder::class, function (Faker $faker) {
  return [
    'name' => \Illuminate\Support\Str::random(50),
    'random_name' => \Illuminate\Support\Str::random(50),
    'created_by' => array_random(\App\Models\User::pluck('id')->toArray()),
  ];
});

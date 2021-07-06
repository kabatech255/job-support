<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;
use Faker\Factory;

$faker = Factory::create('ja_JP');

$factory->define(Role::class, function ($faker) {
  return [
    'name' => $faker->unique()->jobTitle,
    'value' => $faker->unique()->numberBetween(1, 20),
  ];
});

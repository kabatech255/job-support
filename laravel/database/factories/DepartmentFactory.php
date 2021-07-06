<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
  return [
    'department_code' => $faker->unique()->randomNumber(),
    'name' => $faker->unique()->jobTitle,
  ];
});

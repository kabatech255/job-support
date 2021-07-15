<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Faker\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$faker = Factory::create('ja_JP');
$factory->define(Admin::class, function ($faker) {
  return [
    'login_id' => Str::random(8),
    'family_name' => $faker->lastName,
    'given_name' => $faker->firstName,
    'family_name_kana' => $faker->lastKanaName,
    'given_name_kana' => $faker->firstKanaName,
    'email' => $faker->unique()->safeEmail,
    'email_verified_at' => now(),
    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    'remember_token' => Str::random(10),
  ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organization;
use Faker\Generator as Faker;
use Faker\Factory;
use App\Models\User;

$faker = Factory::create('ja_JP');
$factory->define(Organization::class, function ($faker) {
  return [
    'name' => $faker->company(),
    'name_kana' => 'カブシキガイシャ',
    'postal_code' => $faker->postcode,
    'pref_id' => $faker->numberBetween(1, 47),
    'city' => $faker->city,
    'address' => $faker->streetAddress,
    // 'tel' => str_replace('-', '', $faker->phoneNumber),
    'tel' => '1234567890',
    'supervisor_id' => array_random(User::all()->pluck('id')->toArray()),
  ];
});

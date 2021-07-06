<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ChatRoom;
use Faker\Generator as Faker;
use Faker\Factory;
use App\Models\User;

$faker = Factory::create('ja_JP');
$factory->define(ChatRoom::class, function ($faker) {
  return [
    'created_by' => array_random(User::all()->pluck('id')->toArray()),
    'name' => $faker->word . ' ROOM',
  ];
});

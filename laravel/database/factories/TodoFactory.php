<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Todo;
use Faker\Factory;
use App\Models\Priority;
use App\Models\Progress;

$faker = Factory::create('ja_JP');
$factory->define(Todo::class, function ($faker) {
  return [
    'meeting_record_id' => null,
    'owner_id' => $faker->randomNumber,
    'created_by' => $faker->randomNumber,
    'priority_id' => array_random(Priority::all()->pluck('id')->toArray()),
    'progress_id' => array_random(Progress::all()->pluck('id')->toArray()),
    'body' => $faker->sentence(3),
    'time_limit' => $faker->dateTimeThisMonth,
  ];
});

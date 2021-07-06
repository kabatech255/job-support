<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Schedule;
use Faker\Generator as Faker;
use Faker\Factory;
use Illuminate\Support\Carbon;

$faker = Factory::create('ja_JP');

$factory->define(Schedule::class, function ($faker) {
  $today = Carbon::today();
  $start = $today->addDays(random_int(1, 10));
  return [
    'scheduled_by' => $faker->sentence(2),
    'content' => $faker->sentence(2),
    'start_date' => $start,
    'end_date' => $start->addHours(random_int(1,2)),
  ];
});

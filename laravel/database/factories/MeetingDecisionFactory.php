<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MeetingDecision;
use Faker\Generator as Faker;
use Faker\Factory;
use Illuminate\Support\Str;

$faker = Factory::create('ja_JP');

$factory->define(MeetingDecision::class, function ($faker) {
  return [
    'meeting_record_id' => $faker->randomNumber,
    'decided_by' => $faker->numberBetween(1,10),
    'written_by' => $faker->numberBetween(1,10),
    'subject' => $faker->word,
    'body' => Str::substr($faker->realText, 0, 100),
  ];
});

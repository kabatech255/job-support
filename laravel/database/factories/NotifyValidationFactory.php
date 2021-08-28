<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NotifyValidation;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\ActionType;

$factory->define(NotifyValidation::class, function (Faker $faker) {
  return [
    'user_id' => array_random(User::all()->pluck('id')->toArray()),
    'action_type_id' => array_random(ActionType::all()->pluck('id')->toArray()),
    'is_valid' => 1,
  ];
});

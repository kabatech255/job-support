<?php

use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('priorities')->truncate();

    $priorities = [
      [
        'name' => '低',
        'value' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '中',
        'value' => 2,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '高',
        'value' => 3,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('priorities')->insert($priorities);
  }
}

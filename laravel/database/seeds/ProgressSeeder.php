<?php

use Illuminate\Database\Seeder;

class ProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('progress')->truncate();

      $progress = [
        [
          'name' => '未着手',
          'value' => 2,
          'created_at' => now(),
          'updated_at' => now(),
        ],
        [
          'name' => '作業中',
          'value' => 3,
          'created_at' => now(),
          'updated_at' => now(),
        ],
        [
          'name' => '完了',
          'value' => 5,
          'created_at' => now(),
          'updated_at' => now(),
        ],
        [
          'name' => '差戻し',
          'value' => 4,
          'created_at' => now(),
          'updated_at' => now(),
        ],
        [
          'name' => '中止',
          'value' => 0,
          'created_at' => now(),
          'updated_at' => now(),
        ],
        [
          'name' => '中断',
          'value' => 1,
          'created_at' => now(),
          'updated_at' => now(),
        ],
      ];

      DB::table('progress')->insert($progress);
    }
}

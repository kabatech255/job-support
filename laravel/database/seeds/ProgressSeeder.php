<?php

use Illuminate\Database\Seeder;
use App\Models\Progress;

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
        'value' => Progress::COMPLETE_VALUE - 32,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '作業中',
        'value' => Progress::COMPLETE_VALUE - 16,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '完了',
        'value' => Progress::COMPLETE_VALUE,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '一時中断',
        'value' => Progress::COMPLETE_VALUE + 16,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '中止',
        'value' => Progress::COMPLETE_VALUE + 32,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('progress')->insert($progress);
  }
}

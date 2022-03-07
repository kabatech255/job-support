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
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '作業中',
        'value' => Progress::COMPLETE_VALUE - 16,
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '完了',
        'value' => Progress::COMPLETE_VALUE,
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '一時中断',
        'value' => Progress::COMPLETE_VALUE + 16,
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '中止',
        'value' => Progress::COMPLETE_VALUE + 32,
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
    ];

    DB::table('progress')->insert($progress);
  }
}

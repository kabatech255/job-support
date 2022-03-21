<?php

use Illuminate\Database\Seeder;

class ReportCategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('report_categories')->truncate();
    DB::table('report_categories')->insert([
      [
        'code' => '1',
        'name' => 'スパム行為',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'code' => '2',
        'name' => '露骨な性的表現',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'code' => '3',
        'name' => '悪意のある表現や露骨な暴力的表現',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'code' => '4',
        'name' => 'いじめ、いやがらせ',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'code' => '5',
        'name' => '自殺、自傷行為',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'code' => '6',
        'name' => '誤った情報',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ]);
  }
}

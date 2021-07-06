<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tags')->truncate();
    $tags = [
      [
        'name' => '仕事術',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => 'テクノロジー',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => 'HR',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => 'キャリア',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '社会',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '社内トピック',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];
    DB::table('tags')->insert($tags);
  }
}

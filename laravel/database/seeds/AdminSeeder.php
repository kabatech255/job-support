<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('admins')->truncate();

    factory(Admin::class, 1)->create([
      'login_id' => 'testadmin',
      'last_name' => 'テスト',
      'first_name' => '太郎',
      'last_name_kana' => 'テスト',
      'first_name_kana' => 'タロウ',
      'email' => 'test@example.com',
    ]);
  }
}

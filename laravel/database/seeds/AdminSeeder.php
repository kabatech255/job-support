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
      'family_name' => 'テスト',
      'given_name' => '太郎',
      'family_name_kana' => 'テスト',
      'given_name_kana' => 'タロウ',
      'email' => 'test@example.com',
    ]);
  }
}

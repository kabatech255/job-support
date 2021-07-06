<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('roles')->truncate();
    $roles = [
      [
        'name' => '開発者',
        'value' => 255,
      ],
      [
        'name' => 'マネジャー',
        'value' => 100,
      ],
      [
        'name' => 'リーダー',
        'value' => 99,
      ],
      [
        'name' => '一般',
        'value' => 98,
      ],
    ];
    collect($roles)->each(function($role) {
      factory(Role::class, 1)->create($role);
    });
  }
}

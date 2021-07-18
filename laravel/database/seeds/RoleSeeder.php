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
        'name' => 'administrator',
        'label' => '開発者',
        'value' => 255,
      ],
      [
        'name' => 'manager',
        'label' => 'マネージャー',
        'value' => 100,
      ],
      [
        'name' => 'leader',
        'label' => 'リーダー',
        'value' => 99,
      ],
      [
        'name' => 'staff',
        'label' => '一般',
        'value' => 98,
      ],
    ];
    collect($roles)->each(function($role) {
      factory(Role::class, 1)->create($role);
    });
  }
}

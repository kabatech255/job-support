<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->truncate();
    $departmentList = Department::all()->map(function ($department) {
      return [
        [
          'role_id' => 3,
          'department_code' => $department->department_code,
        ],
        [
          'role_id' => 4,
          'department_code' => $department->department_code,
        ],
        [
          'role_id' => 1,
          'department_code' => $department->department_code,
        ],
        [
          'role_id' => 1,
          'department_code' => $department->department_code,
        ],
        [
          'role_id' => 1,
          'department_code' => $department->department_code,
        ],
      ];
    });
    factory(User::class, 1)->create([
      'department_code' => 5,
      'user_code' => 111111,
      'role_id' => 2,
      'login_id' => 'testman1',
      'family_name' => 'テスト',
      'given_name' => '太郎',
      'family_name_kana' => 'テスト',
      'given_name_kana' => 'タロウ',
      'email' => 'test@example.com',
    ]);
    $departmentList->each(function ($department) {
      collect($department)->each(function ($member) {
        factory(User::class, 1)->create($member);
      });
    })->all();
  }
}

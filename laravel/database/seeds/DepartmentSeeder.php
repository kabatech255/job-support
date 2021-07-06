<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('departments')->truncate();

    $departments = [
      [
        'department_code' => '1',
        'name' => '営業部',
      ],
      [
        'department_code' => '2',
        'name' => '総務部',
      ],
      [
        'department_code' => '3',
        'name' => '業務管理部',
      ],
      [
        'department_code' => '4',
        'name' => 'システム開発部',
      ],
      [
        'department_code' => '5',
        'name' => 'システム運用部',
      ],
    ];

    collect($departments)->each(function($department){
      factory(Department::class, 1)->create($department);
    });
  }
}

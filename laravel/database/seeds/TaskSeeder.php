<?php

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Priority;
use App\Models\Progress;

class TaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // MeetingSeederでtruncateするのでここでは不要
    $testUser = DB::table('users')->first();
    factory(Task::class, 100)->create([
      'owner_id' => $testUser->id,
      'created_by' => $testUser->id,
    ]);
  }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Todo;
use App\Models\Priority;
use App\Models\Progress;

class TodoSeeder extends Seeder
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
    factory(Todo::class, 10)->create([
      'owner_id' => $testUser->id,
      'created_by' => $testUser->id,
    ]);
  }
}

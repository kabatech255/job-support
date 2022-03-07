<?php

use App\Common\TestUser;
use Illuminate\Database\Seeder;

class MeetingPlaceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('meeting_places')->truncate();

    $meetingPlaces = [
      [
        'name' => '会議室1',
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '会議室2',
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
      [
        'name' => '会議室3',
        'created_at' => now(),
        'updated_at' => now(),
        'created_by' => TestUser::id(),
        'updated_by' => TestUser::id(),
      ],
    ];

    DB::table('meeting_places')->insert($meetingPlaces);
  }
}

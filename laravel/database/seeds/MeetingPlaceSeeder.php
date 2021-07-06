<?php

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
      ],
      [
        'name' => '会議室2',
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'name' => '会議室3',
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    DB::table('meeting_places')->insert($meetingPlaces);
  }
}

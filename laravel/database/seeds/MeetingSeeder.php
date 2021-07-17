<?php

use Illuminate\Database\Seeder;
use App\Models\MeetingRecord;
use App\Models\MeetingDecision;
use App\Models\User;
use App\Models\Todo;
use App\Models\Priority;
use App\Models\Progress;
use App\Models\MeetingPlace;

class MeetingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('todos')->truncate();
    DB::table('meeting_decisions')->truncate();
    DB::table('meeting_members')->truncate();
    DB::table('meeting_records')->truncate();
    $testUser = DB::table('users')->first();
    for($i = 0; $i < 10; $i++) {
      $members = User::all()->pluck('id')->shuffle()->splice(0, random_int(2, 15))->all();
      $writtenBy = array_random($members);
      // 議事録の追加
      $meetingRecord = factory(MeetingRecord::class)->create([
        'recorded_by' => $writtenBy,
      ]);
      // 参加者の追加
      $meetingRecord->members()->sync($members);
      // 決議事項の追加
      $meetingDecisions = factory(MeetingDecision::class, random_int(1, 4))->create([
        'meeting_record_id' => $meetingRecord->id,
        'decided_by' => array_random($members),
        'written_by' => $writtenBy,
      ]);
      // 議事録からのTodoの追加
      $meetingDecisions->each(function($meetingDecision) {
        factory(Todo::class, 1)->create([
          'meeting_decision_id' => $meetingDecision->id,
          'owner_id' => array_random(User::all()->pluck('id')->toArray()),
          'created_by' => $meetingDecision->written_by,
        ]);
      });
//      $random = array_random([0,0,1]);
    }
  }
}

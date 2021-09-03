<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ActionType;
use App\Models\NotifyValidation;

class ActionTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('notify_validations')->truncate();
    DB::table('action_types')->truncate();

    $types = [
      [
        'key' => 'meeting_record_joined',
        'name' => '議事録が追加されたとき',
      ],
      [
        'key' => 'schedule_shared',
        'name' => '新たなスケジュールが共有されたとき',
      ],
      [
        'key' => 'message_sent',
        'name' => '所属するチャットグループにメッセージが届いた時',
      ],
    ];

    $actionTypeIds = collect($types)->map(function ($type) {
      $newActionType = factory(ActionType::class)->create($type);
      return $newActionType->id;
    })->all();

    $users = User::all();

    $users->each(function ($user) use ($actionTypeIds) {
      foreach ($actionTypeIds as $actionTypeId) {
        $user->notifyValidations()->create([
          'action_type_id' => (int)$actionTypeId,
          'is_valid' => $actionTypeId == 3 ? 0 : 1,
        ]);
      }
    });
  }
}

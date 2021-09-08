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
    DB::table('activities')->truncate();
    DB::table('notify_validations')->truncate();
    DB::table('action_types')->truncate();

    $types = [
      [
        'key' => 'meeting_record_joined',
        'label_name' => '議事録が追加されたとき',
        'template_message' => ':fromさんから議事録「:body」が追加されました',
        'link' => '/mypage/meeting_record/:id',
      ],
      [
        'key' => 'schedule_shared',
        'label_name' => '新たなスケジュールが共有されたとき',
        'template_message' => ':fromさんからスケジュール「:body」が共有されました',
        'link' => '/mypage/schedule',
      ],
      [
        'key' => 'message_sent',
        'label_name' => '所属するチャットグループにメッセージが届いた時',
        'template_message' => ':fromさんが新着メッセージ「:body」を投稿しました',
        'link' => '/mypage/chat/:id',
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
          'is_valid' => 0,
        ]);
      }
    });
  }
}

<?php

namespace Tests\Feature;

use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\MeetingMember;
use App\Models\MeetingPlace;
use App\Models\MeetingRecord;
use App\Models\Priority;
use App\Models\Progress;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Carbon\Carbon;

class MeetingRecordTest extends TestCase
{
  /**
   * @test
   * @group meeting_record
   */
  public function should_議事録の一覧を返却する()
  {
    $response = $this->actingAs($this->user)->getJson(route('meetingRecord.index'));
    $response->assertOk();
    $result = parent::$openApiValidator->validate('getMeetingRecord', 200, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_未認証時にunauthorizedを返却する()
  {
    $response = $this->getJson(route('meetingRecord.index'));
    $response->assertUnauthorized();
    $result = parent::$openApiValidator->validate('getMeetingRecord', 401, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_議事録の投稿()
  {
    $expects = [
      'recorded_by' => $this->user->id,
      'place_id' => array_random(MeetingPlace::pluck('id')->toArray()),
      'meeting_date' => Carbon::now()->format('Y/m/d H:i:s'),
      'title' => '会議名',
      'summary' => 'This is a summary of the meeting from expects.',
      'members' => User::pluck('id')->shuffle()->splice(0, 2)->all(),
      'meeting_decisions' => $this->decisionPostData(),
    ];
    $count = MeetingMember::count();
    $response = $this->actingAs($this->user)->postJson(route('meetingRecord.store'), $expects);
    $response->assertCreated();
    $meetingRecord = MeetingRecord::with(['decisions'])
      ->latest()
      ->first();
    // 会議議事録
    $this->assertDatabaseHas('meeting_records', [
      'id' => $meetingRecord->id,
      'meeting_date' => $expects['meeting_date'],
      'title' => $expects['title'],
      'summary' => $expects['summary'],
    ]);
    // 会議参加者
    $this->assertDatabaseHas('meeting_members', [
      'id' => $meetingRecord->id,
    ])->assertDatabaseCount('meeting_members', $count + count($expects['members']));
    // 会議の決議事項
    $this->assertDatabaseHas('meeting_decisions', [
      'meeting_record_id' => $meetingRecord->id,
      'subject' => $expects['meeting_decisions'][0]['subject'],
      'body' => $expects['meeting_decisions'][0]['body'],
    ]);
    // 決議事項にひもづくタスク
    $this->assertDatabaseHas('todos', [
      'meeting_decision_id' => $meetingRecord->decisions->first()->id,
      'body' => $expects['meeting_decisions'][0]['todos'][0]['body'],
    ]);

    $result = parent::$openApiValidator->validate('postMeetingRecord', 201, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_バリデーションエラー()
  {
    $willDenied = [
      'recorded_by' => 134, // usersテーブルにないID
      'place_id' => 9999, // placesテーブルにないID
      'meeting_date' => Carbon::now()->format('Y-m-d H:i:s'), // フォーマットが違う
      'title' => Str::random(81), // 80文字を超えている
      'members' => [134], // usersテーブルにないID
      'meeting_decisions' => [
        [
          'decided_by' => 134,  // usersテーブルにないID
          'written_by' => 134,  // usersテーブルにないID
          'subject' => Str::random(81), // 80文字を超えている
          'body' => Str::random(141), // 140文字を超えている
          // タスク
          'todos' => [
            [
              'owner_id' => 134,  // usersテーブルにないID
              'created_by' => 134,  // usersテーブルにないID
              'priority_id' => 9999,  // prioritiessテーブルにないID
              'progress_id' => 9999,  // progressテーブルにないID
              'body' => Str::random(141), // 140文字を超えている
              'time_limit' => Carbon::now()->format('Y-m-d H:i:s'),  // フォーマットが違う
            ]
          ]
        ],
      ]
    ];

    $response = $this->actingAs($this->user)->postJson(route('meetingRecord.store'), $willDenied);
    $response->assertStatus(422)->assertJsonValidationErrors([
      'recorded_by',
      'place_id',
      'meeting_date',
      'title',
      'members.0',
      'meeting_decisions.0.decided_by',
      'meeting_decisions.0.written_by',
      'meeting_decisions.0.subject',
      'meeting_decisions.0.body',
      'meeting_decisions.0.todos.0.owner_id',
      'meeting_decisions.0.todos.0.created_by',
      'meeting_decisions.0.todos.0.priority_id',
      'meeting_decisions.0.todos.0.progress_id',
      'meeting_decisions.0.todos.0.body',
      'meeting_decisions.0.todos.0.time_limit',
    ]);
    $this->assertDatabaseMissing('meeting_records', [
      'title' => $willDenied['title']
    ]);
    $this->assertDatabaseMissing('meeting_decisions', [
      'subject' => $willDenied['meeting_decisions'][0]['subject']
    ]);
    $this->assertDatabaseMissing('todos', [
      'body' => $willDenied['meeting_decisions'][0]['todos'][0]['body']
    ]);

    $result = parent::$openApiValidator->validate('postMeetingRecord', 422, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_未認証時に議事録を追加しようとするとunauthorizedを返却する()
  {
    $expects = [
      'recorded_by' => $this->user->id,
      'place_id' => array_random(MeetingPlace::pluck('id')->toArray()),
      'meeting_date' => Carbon::now()->format('Y/m/d H:i:s'),
      'title' => '会議名',
      'summary' => 'This is a summary of the meeting from expects.',
      'members' => [],
      'meeting_decisions' => $this->decisionPostData(),
    ];

    $response = $this->postJson(route('meetingRecord.store'), $expects);
    $response->assertUnauthorized();
    $result = parent::$openApiValidator->validate('postMeetingRecord', 401, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_議事録の更新()
  {
    $meetingRecord = factory(MeetingRecord::class)->create([
      'recorded_by' => $this->user->id,
    ]);
    $members = User::pluck('id')->shuffle()->splice(0, 2)->all();
    $meetingRecord->members()->sync($members);
    $meetingDecisions = factory(MeetingDecision::class, 2)->create([
      'meeting_record_id' => $meetingRecord->id,
      'decided_by' => $this->user->id,
      'written_by' => $this->user->id,
    ]);
    factory(Todo::class, 2)->create([
      'meeting_decision_id' => $meetingDecisions->first()->id,
      'owner_id' => array_random($members),
      'created_by' => $this->user->id,
    ]);
    $expects = [
      'recorded_by' => $meetingRecord->recorded_by,
      'place_id' => $meetingRecord->place_id,
      'meeting_date' => Carbon::make($meetingRecord->meeting_date)->format('Y/m/d H:i:s'),
      'title' => $meetingRecord->title . '_update',
      'summary' => $meetingRecord->summary . '_update',
      'members' => $meetingRecord->members->pluck('id')->toArray(),
      'meeting_decisions' => array_merge($this->decisionsPutData($meetingDecisions), $this->decisionPostData()),
    ];
    $decisionCount = MeetingDecision::count();
    $todoCount = Todo::count();
    $response = $this->actingAs($this->user)->putJson(route('meetingRecord.update', $meetingRecord->id), $expects);
    $response->assertOk();

    // 会議議事録
    $this->assertDatabaseHas('meeting_records', [
      'id' => $meetingRecord->id,
      'meeting_date' => $expects['meeting_date'],
      'title' => $expects['title'],
      'summary' => $expects['summary'],
    ]);

    // 会議の決議事項
    $this->assertDatabaseHas('meeting_decisions', [
      // 更新した決議事項
      'id' => $meetingDecisions->first()->id,
      'subject' => $expects['meeting_decisions'][0]['subject'],
      'body' => $expects['meeting_decisions'][0]['body'],
    ])->assertDatabaseHas('meeting_decisions', [
      'meeting_record_id' => $meetingRecord->id,
      'subject' => $expects['meeting_decisions'][2]['subject'],
      'body' => $expects['meeting_decisions'][2]['body'],
    ]);
    $this->assertSoftDeleted('meeting_decisions', [
      'id' => $meetingDecisions->last()->id,
    ]);
    // 1件ソフトデリートして1件新規追加 => プラス1
    $this->assertDatabaseCount('meeting_decisions', $decisionCount + 1);

    // 決議事項にひもづくタスク
    $lastDecision = MeetingDecision::latest()->first();
    $this->assertDatabaseHas('todos', [
      // 更新したタスク
      'id' => $meetingDecisions->first()->todos->first()->id,
      'body' => $expects['meeting_decisions'][0]['todos'][0]['body'],
    ])->assertDatabaseHas('todos', [
      // 追加したタスク
      'meeting_decision_id' => $meetingDecisions->first()->id,
      'body' => $expects['meeting_decisions'][0]['todos'][2]['body'],
    ])->assertDatabaseHas('todos', [
      // 新規追加した決議事項に紐づく新規タスク
      'meeting_decision_id' => $lastDecision->id,
      'body' => $expects['meeting_decisions'][2]['todos'][0]['body'],
    ]);
    $this->assertSoftDeleted('todos', [
      'id' => $meetingDecisions->first()->todos->last()->id,
    ]);
    // 1件ソフトデリートして2件新規追加 => プラス2
    $this->assertDatabaseCount('todos', $todoCount + 2);

    $result = parent::$openApiValidator->validate('putMeetingRecordId', 200, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_投稿者以外の更新リクエストにはForbiddenを返却する()
  {
    $meetingRecord = factory(MeetingRecord::class)->create([
      'recorded_by' => $this->user->id,
    ]);
    $willDenied = [
      'recorded_by' => $meetingRecord->recorded_by,
      'place_id' => $meetingRecord->place_id,
      'meeting_date' => Carbon::make($meetingRecord->meeting_date)->format('Y/m/d H:i:s'),
      'title' => $meetingRecord->title . '_update',
      'summary' => $meetingRecord->summary . '_update',
      'members' => $meetingRecord->members->pluck('id')->toArray(),
    ];
    $user = User::where('id', '!=', $meetingRecord->recorded_by)->first();
    $response = $this->actingAs($user)->putJson(route('meetingRecord.update', $meetingRecord->id), $willDenied);
    $response->assertForbidden();

    $result = parent::$openApiValidator->validate('putMeetingRecordId', 403, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_議事録の詳細表示()
  {
    $response = $this->actingAs($this->user)->getJson(route('meetingRecord.show', 1));
    $response->assertOk();

    $result = parent::$openApiValidator->validate('getMeetingRecordId', 200, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_存在しない議事録IDにアクセスしたらNotfound()
  {
    $response = $this->actingAs($this->user)->getJson(route('meetingRecord.show', 1111));
    $response->assertNotFound();

    $result = parent::$openApiValidator->validate('getMeetingRecordId', 404, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @test
   * @group meeting_record
   */
  public function should_議事録の削除()
  {
    $meetingRecord = MeetingRecord::orderBy('id', 'desc')->first();
    $user = User::find($meetingRecord->recorded_by);
    $response = $this->actingAs($user)->deleteJson(route('meetingRecord.destroy', $meetingRecord->id));
    $response->assertNoContent();
    $this->assertSoftDeleted('meeting_records', [
      'id' => $meetingRecord->id
    ]);
    $result = parent::$openApiValidator->validate('deleteMeetingRecordId', 204, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }
  /**
   * @test
   * @group meeting_record
   */
  public function should_投稿者以外の削除リクエストにはForbiddenを返却する()
  {
    $meetingRecord = MeetingRecord::orderBy('id', 'desc')->first();
    $exceptUser = User::where('id','!=', $meetingRecord->recorded_by)->first();
    $response = $this->actingAs($exceptUser)->deleteJson(route('meetingRecord.destroy', $meetingRecord->id));
    $response->assertForbidden();
    $this->assertDatabaseHas('meeting_records', [
      'id' => $meetingRecord->id,
      'deleted_at' => null,
    ]);

    $result = parent::$openApiValidator->validate('deleteMeetingRecordId', 403, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }

  /**
   * @param $decisions
   * @return array[]
   */
  private function decisionsPutData($decisions): array
  {
    return $decisions->map(function($decision, $index) {
      return [
        'id' => $decision->id,
        'flag' => $index > 0 ? ProcessFlag::value('delete') : ProcessFlag::value('update'),
        'decided_by' => $decision->decided_by,
        'written_by' => $decision->written_by,
        'subject' => $index > 0 ? $decision->subject : $decision->subject . '_update',
        'body' => $index > 0 ? $decision->body : $decision->body . '_update',
        // タスク
        'todos' =>  $index > 0 ? $this->todosPutData($decision->todos) : array_merge($this->todosPutData($decision->todos), $this->todoPostData()),
      ];
    })->all();
  }

  /**
   * @return array[]
   */
  private function decisionPostData(): array
  {
    return [
      [
        'decided_by' => array_random(User::pluck('id')->toArray()),
        'written_by' => $this->user->id,
        'subject' => 'this is a new subject from expects.',
        'body' => 'this is a new body of the decision from expects.',
        // タスク
        'todos' => $this->todoPostData(),
      ]
    ];
  }

  /**
   * @param $todos
   * @return array[]
   */
  private function todosPutData($todos): array
  {
    return $todos->map(function($todo, $i) {
      return [
        'id' => $todo->id,
        'flag' => $i > 0 ? ProcessFlag::value('delete') : ProcessFlag::value('update'),
        'owner_id' => $todo->owner_id,
        'created_by' => $todo->created_by,
        'priority_id' => $todo->priority_id,
        'progress_id' => $todo->progress_id,
        'body' => $i > 0 ? $todo->body : $todo->body . '_update',
        'time_limit' => Carbon::parse($todo->time_limit)->format('Y/m/d H:i:s'),
      ];
    })->all();
  }

  /**
   * @return array[]
   */
  private function todoPostData(): array
  {
    return [
      [
        'owner_id' => array_random(User::pluck('id')->toArray()),
        'created_by' => $this->user->id,
        'priority_id' => array_random(Priority::pluck('id')->toArray()),
        'progress_id' => array_random(Progress::pluck('id')->toArray()),
        'body' => 'this is a new body of the task.',
        'time_limit' => Carbon::now()->format('Y/m/d H:i:s'),
      ]
    ];
  }
}

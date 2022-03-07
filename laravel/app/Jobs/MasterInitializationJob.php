<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MasterInitializationJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $user;
  private $departments;
  private $progress;
  private $meetingPlaces;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($user)
  {
    $this->user = $user;
    $now = now();
    $this->departments = [
      [
        'department_code' => null,
        'name' => '営業部',
        'color' => null,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'department_code' => null,
        'name' => '総務部',
        'color' => null,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
    ];
    $this->progress = [
      [
        'name' => '未着手',
        'value' => 1,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '作業中',
        'value' => 2,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '完了',
        'value' => 3,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '一時中断',
        'value' => 4,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '中止',
        'value' => 5,
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
    ];
    $this->meetingPlaces = [
      [
        'name' => '会議室1',
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '会議室2',
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
      [
        'name' => '会議室3',
        'created_by' => $this->user->id,
        'updated_by' => $this->user->id,
        'created_at' => $now,
        'updated_at' => $now,
      ],
    ];
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    \DB::table('departments')->insert($this->departments);
    \DB::table('progress')->insert($this->progress);
    \DB::table('meeting_places')->insert($this->meetingPlaces);
  }
}

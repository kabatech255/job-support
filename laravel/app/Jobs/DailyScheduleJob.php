<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Queries\UserQuery;
use App\Models\ActionType;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DailyScheduleNotification;
use App\Models\User;


class DailyScheduleJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * @var UserQuery
   */
  private $userQuery;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $user = new User();
    $this->userQuery = new UserQuery($user);
    $notifiableUser = $this->userQuery->getNotifiableOf(ActionType::DAILY_ALERT_ARR[ActionType::LIMIT_SCHEDULE_KEY]);
    Notification::send($notifiableUser, new DailyScheduleNotification());
  }
}

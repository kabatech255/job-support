<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
// use App\Contracts\Queries\UserQueryInterface as UserQuery;
use App\Queries\UserQuery;
use App\Models\ActionType;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DailyLimitTaskNotification;
use App\Models\User;

class DailyLimitTaskJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * @var UserQuery
   */
  private $userQuery;
  /**
   * UserQuery $userQuery
   *
   * @return void
   */
  public function __construct()
  {
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
    $notifiableUser = $this->userQuery->getNotifiableOf(ActionType::DAILY_ALERT_ARR[ActionType::LIMIT_TASK_KEY]);
    Notification::send($notifiableUser, new DailyLimitTaskNotification());
  }
}

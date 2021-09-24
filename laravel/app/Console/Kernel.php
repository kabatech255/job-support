<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\DailyLimitTaskJob;
use App\Jobs\DailyScheduleJob;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // 明日締切のタスクを通知するジョブ
    $schedule->job(new DailyLimitTaskJob, 'daily_notification')
      ->at('18:00');
    // ->everyMinute();

    // 本日の予定を通知するジョブ
    $schedule->job(new DailyScheduleJob, 'daily_notification')
      ->at('8:00');
    // ->everyMinute();
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');
    require base_path('routes/console.php');
  }
}

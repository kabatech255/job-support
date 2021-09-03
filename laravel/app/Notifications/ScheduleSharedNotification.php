<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Schedule;

class ScheduleSharedNotification extends Notification implements ShouldQueue
{
  use Queueable;
  public $schedule;
  public $subjectPrefix;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Schedule $schedule)
  {
    $this->schedule = $schedule;
    // $this->queue = 'schedule_shared';
    $this->subjectPrefix = config('app.name');
  }

  /**
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable)
  {
    return (new MailMessage)
      ->subject("【{$this->subjectPrefix}】新しい予定が共有されました")
      ->markdown('mail.schedule.shared', [
        'schedule' => $this->schedule,
        'detailUrl' => config('app.front_url', 'http://localhost:3000') . '/mypage/schedule',
      ]);
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }
}

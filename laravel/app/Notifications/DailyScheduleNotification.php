<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class DailyScheduleNotification extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->subjectPrefix = config('app.name');
    $this->queue = 'daily_notification';
  }

  /**
   * Get the notification's delivery channels.
   *
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
    $scheduleList = $notifiable->sharedSchedules->filter(function ($schedule) {
      return Carbon::parse($schedule->start)->format('Y-m-d H:i:s') < Carbon::tomorrow()->format('Y-m-d H:i:s')
        && Carbon::parse($schedule->end)->format('Y-m-d H:i:s') >= Carbon::today()->format('Y-m-d H:i:s');
    });
    return (new MailMessage)
      ->subject("【{$this->subjectPrefix}】本日の予定")
      ->markdown('mail.schedule.today', [
        'scheduleList' => $scheduleList,
        'notifiable' => $notifiable,
        'detailUrl' => config('app.front_url', 'http://localhost:3000') . '/mypage/task',
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

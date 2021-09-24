<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class DailyLimitTaskNotification extends Notification
{
  use Queueable;
  public $subjectPrefix;
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
    $taskList = $notifiable->tasks->filter(function ($task) {
      return Carbon::parse($task->time_limit)->format('Y-m-d') === Carbon::tomorrow()->format('Y-m-d')
        && !$task->is_except;
    });
    return (new MailMessage)
      ->subject("【{$this->subjectPrefix}】明日締切のタスク")
      ->markdown('mail.task.limited', [
        'taskList' => $taskList,
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

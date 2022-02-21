<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCreatedNotification extends Notification implements ShouldQueue
{
  use Queueable;

  public $inviter;
  public $subjectPrefix;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Authenticatable $inviter)
  {
    $this->subjectPrefix = config('app.name');
    $this->inviter = $inviter;
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
    $tempArr = $notifiable->toArray();
    foreach ($tempArr as $key => $val) {
      if (gettype($key) === 'string' && in_array($key, ['email', 'family_name', 'family_name_kana', 'given_name', 'given_name_kana'])) {
        $slim[$key] = base64_encode($val);
      }
    }

    $query = \Arr::query([
      'email' => $slim['email'],
      'family_name' => $slim['family_name'],
      'family_name_kana' => $slim['family_name_kana'],
      'given_name' => $slim['given_name'],
      'given_name_kana' => $slim['given_name_kana'],
    ]);

    return (new MailMessage)
      ->subject("【{$this->subjectPrefix}】{$this->inviter->full_name}さんから管理者システムに招待されました")
      ->markdown('mail.admin.created', [
        'notifiable' => $notifiable,
        'accountSetupUrl' => config('app.admin_front_url', 'http://localhost:3001') . '/account_setup?' . $query,
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

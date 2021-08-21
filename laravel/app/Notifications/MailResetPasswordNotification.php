<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class MailResetPasswordNotification extends ResetPassword
{
  use Queueable;

  /** @var string */
  public $token;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($token)
  {
    $this->token = $token;
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
    $appUrl = config('app.front_url', 'http://localhost:3000');
    return (new MailMessage)
      ->subject('【' . config('app.name') . '】パスワード再設定のご案内')
      ->view('mail.forgot_password', [
        'resetUrl' => $appUrl . "/password/reset/{$this->token}?email=" . base64_encode($notifiable->getEmailForPasswordReset()),
        'forgotPasswordUrl' => $appUrl[0] . '/password/forgot_password',
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

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MeetingRecord;

class MeetingRecordJoinedNotification extends Notification implements ShouldQueue
{
  use Queueable;
  public $meetingRecord;
  public $subjectPrefix;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(MeetingRecord $meetingRecord)
  {
    $this->meetingRecord = $meetingRecord;
    $this->queue = 'meeting_record_joined';
    $this->subjectPrefix = config('app.name');
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
    return (new MailMessage)
      ->subject("【{$this->subjectPrefix}】議事録が追加されました")
      ->markdown('mail.meeting_record.joined', [
        'meetingRecord' => $this->meetingRecord,
        'notifiable' => $notifiable,
        'detailUrl' => config('app.front_url', 'http://localhost:3000') . '/mypage/meeting_record/' . $this->meetingRecord->id,
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

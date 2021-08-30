<?php

namespace App\Events;

use App\Models\ChatRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// ShouldBroadcastNowをimplementsし、キュー接続ドライバのデフォルト設定に関わらずsyncでイベントをブロードキャストする
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class MessageRead implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;
  public $chatRoomId;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(Authenticatable $user, $chatRoomId)
  {
    $this->user = $user;
    $this->chatRoomId = $chatRoomId;
  }

  /**
   * ブロードキャストするデータを取得
   *
   * @return array
   */
  public function broadcastWith()
  {
    return [
      'readUser' => $this->user,
      'chatRoomId' => $this->chatRoomId,
    ];
  }
  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new Channel('chat', $this->user, $this->chatRoomId);
  }
}

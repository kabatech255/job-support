<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoomShare extends Model
{
  protected $table = 'chat_room_shares';
  protected $fillable = [
    'shared_by'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sharedBy()
  {
    return $this->belongsTo(User::class, 'shared_by', 'login_id');
  }
}

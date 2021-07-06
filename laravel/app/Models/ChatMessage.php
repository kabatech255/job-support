<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
  protected $table = 'chat_messages';

  protected $fillable = [
    'chat_room_id',
    'written_by',
    'mentioned_to',
    'body',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function writtenBy()
  {
    return $this->belongsTo(User::class, 'written_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function chatRoom()
  {
    return $this->belongsTo(ChatRoom::class, 'chat_room_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function images()
  {
    return $this->hasMany('chat_message_images', 'chat_message_id', 'id');
  }

}

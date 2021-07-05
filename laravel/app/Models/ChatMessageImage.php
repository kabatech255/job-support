<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessageImage extends Model
{
  protected $table = 'chat_message_images';

  protected $fillable = [
    'chat_message_id',
    'file_path',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function chatMessage()
  {
    return $this->belongsTo(ChatMessage::class, 'chat_message_id', 'id');
  }
}

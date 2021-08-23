<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessageRead extends Model
{
  protected $table = 'chat_message_reads';

  protected $fillable = [
    'chat_message_id',
    'member_id',
  ];
}

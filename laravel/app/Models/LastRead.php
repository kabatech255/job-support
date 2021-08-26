<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastRead extends Model
{
  protected $table = 'last_reads';
  protected $fillable = [
    'chat_room_id',
    'member_id',
    'last_message_id',
  ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
  protected $table = 'chat_rooms';
  protected $fillable = [
    'created_by',
    'name',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedMembers()
  {
    return $this->belongsToMany(User::class, 'chat_room_shares', 'chat_room_id', 'shared_with')
      ->withTimestamps()->withPivot('shared_by');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function messages()
  {
    return $this->hasMany(ChatMessage::class, 'chat_room_id', 'id');
  }
}

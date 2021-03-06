<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;

/**
 * App\Models\ChatRoomShare
 *
 * @property int $id
 * @property int $chat_room_id ルームID
 * @property int $shared_with 共有相手
 * @property int $shared_by 共有した人
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $sharedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereChatRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereSharedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereSharedWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $is_editable 編集権限
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoomShare whereIsEditable($value)
 */
class ChatRoomShare extends Model
{
  protected $table = 'chat_room_shares';
  protected $fillable = [
    'shared_by',
    'is_editable',
  ];

  protected $casts = [
    'is_editable' => 'boolean'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sharedBy()
  {
    return $this->belongsTo(User::class, 'shared_by', 'id');
  }
}

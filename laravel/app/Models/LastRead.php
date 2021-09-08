<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LastRead
 *
 * @property int $id
 * @property int $chat_room_id
 * @property int $member_id
 * @property int $last_message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead query()
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereChatRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LastRead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LastRead extends Model
{
  protected $table = 'last_reads';
  protected $fillable = [
    'chat_room_id',
    'member_id',
    'last_message_id',
  ];
}

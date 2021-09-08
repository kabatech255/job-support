<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChatMessageRead
 *
 * @property int $id
 * @property int $chat_message_id チャットメッセージID
 * @property int $member_id ユーザID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead whereChatMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessageRead whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChatMessageRead extends Model
{
  protected $table = 'chat_message_reads';

  protected $fillable = [
    'chat_message_id',
    'member_id',
  ];
}

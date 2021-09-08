<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reaction
 *
 * @property int $id
 * @property int $chat_message_id チャットメッセージID
 * @property int $member_id ユーザID
 * @property int $facial_expression_id 表情ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FacialExpression|null $facialExpression
 * @property-read \App\Models\User|null $member
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereChatMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereFacialExpressionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reaction extends Model
{
  protected $table = 'reactions';

  protected $fillable = [
    'chat_message_id',
    'member_id',
    'facial_expression_id',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function member()
  {
    return $this->hasOne(User::class, 'id', 'member_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function facialExpression()
  {
    return $this->hasOne(FacialExpression::class, 'id', 'facial_expression_id');
  }
}

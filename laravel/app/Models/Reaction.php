<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Contracts\Models\ModelInterface;

class NotifyValidation extends Model implements ModelInterface
{
  protected $table = 'notify_validations';

  protected $fillable = [
    'user_id',
    'action_type_id',
    'is_valid',
  ];

  protected $cast = [
    'is_valid' => 'boolean'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function actionType()
  {
    return $this->belongsTo(ActionType::class, 'action_type_id', 'id');
  }
}

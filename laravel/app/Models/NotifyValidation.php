<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Contracts\Models\ModelInterface;

/**
 * App\Models\NotifyValidation
 *
 * @property int $id
 * @property int $user_id ユーザID
 * @property int $action_type_id アクションID
 * @property int $is_valid 許可・不許可
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ActionType $actionType
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereActionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotifyValidation whereUserId($value)
 * @mixin \Eloquent
 */
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

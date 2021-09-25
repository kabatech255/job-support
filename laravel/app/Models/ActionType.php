<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Contracts\Models\ModelInterface;

/**
 * App\Models\ActionType
 *
 * @property int $id
 * @property string $key アクションキー
 * @property string $label_name アクション名
 * @property string $template_message テンプレートメッセージ
 * @property string $link リンク
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereLabelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereTemplateMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActionType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActionType extends Model implements ModelInterface
{
  protected $table = 'action_types';

  protected $fillable = [
    'name',
    'template_message',
    'link',
  ];

  const SCHEDULE_SHARED_KEY = 'schedule_shared';
  const MESSAGE_SENT_KEY = 'message_sent';
  const MEETING_RECORD_JOINED_KEY = 'meeting_record_joined';
  const LIMIT_TASK_KEY = 'daily_limit_task';
  const LIMIT_SCHEDULE_KEY = 'daily_schedule';
  const DAILY_ALERT_ARR = [
    self::LIMIT_TASK_KEY => 4,
    self::LIMIT_SCHEDULE_KEY => 5,
  ];
}

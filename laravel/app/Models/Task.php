<?php

namespace App\Models;

use App\Contracts\Models\ModelInterface;
use App\Models\Abstracts\CommonModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int|null $meeting_decision_id 会議決定事項ID
 * @property int $owner_id 担当者
 * @property int $created_by 作成者
 * @property int|null $priority_id 優先順位ID
 * @property int|null $progress_id 進捗度ID
 * @property string $body 内容
 * @property int $time_limit 期日
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\MeetingRecord|null $meeting
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\Priority|null $priority
 * @property-read \App\Models\Progress|null $progress
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Query\Builder|Task onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereMeetingRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePriorityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProgressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTimeLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Task withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\MeetingDecision|null $meetingDecision
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereMeetingDecisionId($value)
 */
class Task extends Model implements ModelInterface
{
  use SoftDeletes;

  protected $table = 'tasks';
  protected $fillable = [
    'meeting_record_id',
    'owner_id',
    'created_by',
    'priority_id',
    'progress_id',
    'body',
    'time_limit',
  ];

  protected $casts = [
    'time_limit' => 'date_time',
  ];
  protected $dates = [
    'time_limit',
  ];

  const RELATIONS_ARRAY = [
    'createdBy', 'owner', 'priority', 'progress',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function meetingDecision()
  {
    return $this->belongsTo(MeetingDecision::class, 'meeting_decision_id', 'id');
  }
  /**
   * Taskの担当者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function owner()
  {
    return $this->belongsTo(User::class, 'owner_id', 'id');
  }
  /**
   * 議事録作成者に登録されたTask
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function priority()
  {
    return $this->belongsTo(Priority::class, 'priority_id', 'id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function progress()
  {
    return $this->belongsTo(Progress::class, 'progress_id', 'id');
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
  use SoftDeletes;

  protected $table = 'todos';
  protected $fillable = [
    'meeting_record_id',
    'owner_id',
    'created_by',
    'priority_id',
    'body',
    'time_limit',
  ];

  protected $casts = [
    'time_limit' => 'timestamp',
  ];
  protected $dates = [
    'time_limit',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function meeting()
  {
    return $this->belongsTo(MeetingRecord::class, 'meeting_record_id', 'id');
  }
  /**
   * Todoの担当者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function owner()
  {
    return $this->belongsTo(User::class, 'owner_id', 'login_id');
  }
  /**
   * 議事録作成者に登録されたTodo
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'login_id');
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

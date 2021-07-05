<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
  use SoftDeletes;

  protected $table = 'schedules';
  protected $fillable = [
    'scheduled_by',
    'content',
    'start_date',
    'end_date',
    'is_public',
    'color',
  ];

  protected $casts = [
    'is_public' => 'boolean',
    'start_date' => 'timestamp',
    'end_date' => 'timestamp',
  ];

  protected $dates = [
    'start_date',
    'end_date',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function scheduledBy()
  {
    return $this->belongsTo(User::class, 'scheduled_by', 'login_id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedMembers()
  {
    return $this->belongsToMany(User::class, 'schedule_shares', 'schedule_id', 'shared_with')
      ->withTimestamps()
      ->withPivot('is_editable', 'shared_by');
  }
}

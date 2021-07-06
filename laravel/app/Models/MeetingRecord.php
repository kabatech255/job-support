<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingRecord extends Model
{
  use SoftDeletes;

  protected $table = 'meeting_records';

  protected $fillable = [
    'recorded_by',
    'updated_by',
    'deleted_by',
    'place_id',
    'meeting_date',
    'title',
    'summary',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'meeting_date' => 'datetime',
  ];

  protected $dates = [
    'meeting_date'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function recordedBy()
  {
    return $this->belongsTo(User::class, 'recorded_by', 'id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function place()
  {
    return $this->belongsTo(MeetingPlace::class, 'place_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function todos()
  {
    return $this->hasMany(Todo::class, 'meeting_record_id', 'id');
  }

  /**
   * ミーティング参加者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function members()
  {
    return $this->belongsToMany(User::class, 'meeting_members', 'meeting_record_id', 'member_id')->withTimestamps();
  }
}

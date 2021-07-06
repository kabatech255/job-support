<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingPlace extends Model
{
  use SoftDeletes;

  protected $table = 'meeting_places';
  protected $fillable = [
    'name',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function meetings()
  {
    return $this->hasMany(MeetingRecord::class, 'meeting_place_id', 'id');
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleShare extends Model
{
  protected $table = ['schedule_shares'];
  protected $fillable = [
    'shared_by',
    'is_editable',
  ];
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sharedBy()
  {
    return $this->belongsTo(User::class, 'shared_by', 'login_id');
  }
}

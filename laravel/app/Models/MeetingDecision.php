<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeetingDecision extends Model
{
  use SoftDeletes;

  protected $table = 'meeting_decisions';

  protected $fillable = [
    'meeting_record_id',
    'decided_by',
    'written_by',
    'subject',
    'body',
  ];

  /**
   * 議事録登録者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function writtenBy()
  {
    return $this->belongsTo(User::class, 'written_by', 'login_id');
  }
  /**
   * 決定者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function decidedBy()
  {
    return $this->belongsTo(User::class, 'decided_by', 'login_id');
  }
  /**
   * 決定者
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function meetingRecord()
  {
    return $this->belongsTo(MeetingRecord::class, 'meeting_record_id', 'id');
  }
}

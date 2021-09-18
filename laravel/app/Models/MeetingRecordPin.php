<?php

namespace App\Models;

use App\Contracts\Models\ModelInterface;
use App\Models\Abstracts\CommonModel as Model;

class MeetingRecordPin extends Model implements ModelInterface
{
  protected $table = 'meeting_record_pins';
  protected $fillable = [
    'user_id',
    'meeting_record_id',
  ];
}

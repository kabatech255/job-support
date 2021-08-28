<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Contracts\Models\ModelInterface;

class ActionType extends Model implements ModelInterface
{
  protected $table = 'action_types';

  protected $fillable = [
    'name',
  ];

  const SCHEDULE_SHARED_KEY = 'schedule_shared';
  const MESSAGE_SENT_KEY = 'message_sent';
  const MEETING_RECORD_JOINED_KEY = 'meeting_record_joined';
}

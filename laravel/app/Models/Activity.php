<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Contracts\Models\ModelInterface;

class Activity extends Model implements ModelInterface
{
  protected $table = 'activities';

  protected $fillable = [
    'action_type_id',
    'user_id',
    'is_read',
  ];
}

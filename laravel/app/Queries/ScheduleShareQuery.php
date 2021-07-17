<?php

namespace App\Queries;

use App\Contracts\Queries\ScheduleShareQueryInterface;
use App\Models\ScheduleShare;
use App\Queries\Abstracts\EloquentQuery;

class ScheduleShareQuery extends EloquentQuery implements ScheduleShareQueryInterface
{
  public function __construct(ScheduleShare $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

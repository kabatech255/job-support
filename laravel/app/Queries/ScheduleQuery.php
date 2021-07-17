<?php

namespace App\Queries;

use App\Contracts\Queries\ScheduleQueryInterface;
use App\Models\Schedule;
use App\Queries\Abstracts\EloquentQuery;

class ScheduleQuery extends EloquentQuery implements ScheduleQueryInterface
{
  public function __construct(Schedule $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

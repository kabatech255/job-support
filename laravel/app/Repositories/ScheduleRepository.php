<?php

namespace App\Repositories;

use App\Contracts\Repositories\ScheduleRepositoryInterface;
use App\Models\Schedule;
use App\Repositories\Abstracts\EloquentRepository;

class ScheduleRepository extends EloquentRepository implements ScheduleRepositoryInterface
{
  public function __construct(Schedule $model)
  {
    $this->setModel($model);
  }
}

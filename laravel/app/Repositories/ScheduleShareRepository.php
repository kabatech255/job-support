<?php

namespace App\Repositories;

use App\Contracts\Repositories\ScheduleShareRepositoryInterface;
use App\Models\ScheduleShare;
use App\Repositories\Abstracts\EloquentRepository;

class ScheduleShareRepository extends EloquentRepository implements ScheduleShareRepositoryInterface
{
  public function __construct(ScheduleShare $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingPlaceRepositoryInterface;
use App\Models\MeetingPlace;
use App\Repositories\Abstracts\EloquentRepository;

class MeetingPlaceRepository extends EloquentRepository implements MeetingPlaceRepositoryInterface
{
  public function __construct(MeetingPlace $model)
  {
    $this->setModel($model);
  }
}

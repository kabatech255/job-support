<?php

namespace App\Queries;

use App\Contracts\Queries\MeetingPlaceQueryInterface;
use App\Models\MeetingPlace;
use App\Queries\Abstracts\EloquentQuery;

class MeetingPlaceQuery extends EloquentQuery implements MeetingPlaceQueryInterface
{
  public function __construct(MeetingPlace $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

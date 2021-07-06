<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingDecisionRepositoryInterface;
use App\Models\MeetingDecision;
use App\Repositories\Abstracts\EloquentRepository;

class MeetingDecisionRepository extends EloquentRepository implements MeetingDecisionRepositoryInterface
{
  public function __construct(MeetingDecision $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Queries;

use App\Contracts\Queries\MeetingDecisionQueryInterface;
use App\Queries\Abstracts\EloquentQuery;
use App\Models\MeetingDecision;
use Illuminate\Database\Eloquent\Builder;

class MeetingDecisionQuery extends EloquentQuery implements MeetingDecisionQueryInterface
{
  public function __construct(MeetingDecision $model)
  {
    $this->setBuilder($model);
  }
}

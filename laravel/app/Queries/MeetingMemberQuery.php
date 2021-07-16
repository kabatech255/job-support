<?php

namespace App\Queries;

use App\Contracts\Queries\MeetingMemberQueryInterface;
use App\Models\MeetingMember;
use App\Queries\Abstracts\EloquentQuery;

class MeetingMemberQuery extends EloquentQuery implements MeetingMemberQueryInterface
{
  public function __construct(MeetingMember $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

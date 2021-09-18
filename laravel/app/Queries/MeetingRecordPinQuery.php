<?php

namespace App\Queries;

use App\Contracts\Queries\MeetingRecordPinQueryInterface;
use App\Models\MeetingRecordPin;
use App\Queries\Abstracts\EloquentQuery;

class MeetingRecordPinQuery extends EloquentQuery implements MeetingRecordPinQueryInterface
{
  public function __construct(MeetingRecordPin $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

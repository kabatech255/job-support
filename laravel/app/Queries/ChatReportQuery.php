<?php

namespace App\Queries;

use App\Contracts\Queries\ChatReportQueryInterface;
use App\Models\ChatReport;
use App\Queries\Abstracts\EloquentQuery;

class ChatReportQuery extends EloquentQuery implements ChatReportQueryInterface
{
  public function __construct(ChatReport $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

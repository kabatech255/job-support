<?php

namespace App\Queries;

use App\Contracts\Queries\BlogReportQueryInterface;
use App\Models\BlogReport;
use App\Queries\Abstracts\EloquentQuery;

class BlogReportQuery extends EloquentQuery implements BlogReportQueryInterface
{
  public function __construct(BlogReport $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

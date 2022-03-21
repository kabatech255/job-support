<?php

namespace App\Queries;

use App\Contracts\Queries\ReportCategoryQueryInterface;
use App\Models\ReportCategory;
use App\Queries\Abstracts\EloquentQuery;

class ReportCategoryQuery extends EloquentQuery implements ReportCategoryQueryInterface
{
  public function __construct(ReportCategory $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

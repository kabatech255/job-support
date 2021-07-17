<?php

namespace App\Queries;

use App\Contracts\Queries\DepartmentQueryInterface;
use App\Models\Department;
use App\Queries\Abstracts\EloquentQuery;

class DepartmentQuery extends EloquentQuery implements DepartmentQueryInterface
{
  public function __construct(Department $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

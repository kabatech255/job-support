<?php

namespace App\Queries;

use App\Contracts\Queries\RoleQueryInterface;
use App\Models\Role;
use App\Queries\Abstracts\EloquentQuery;

class RoleQuery extends EloquentQuery implements RoleQueryInterface
{
  public function __construct(Role $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

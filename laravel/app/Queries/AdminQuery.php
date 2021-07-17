<?php

namespace App\Queries;

use App\Contracts\Queries\AdminQueryInterface;
use App\Models\Admin;
use App\Queries\Abstracts\EloquentQuery;

class AdminQuery extends EloquentQuery implements AdminQueryInterface
{
  public function __construct(Admin $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

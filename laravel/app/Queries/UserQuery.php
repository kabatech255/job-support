<?php

namespace App\Queries;

use App\Contracts\Queries\UserQueryInterface;
use App\Models\User;
use App\Queries\Abstracts\EloquentQuery;

class UserQuery extends EloquentQuery implements UserQueryInterface
{
  public function __construct(User $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

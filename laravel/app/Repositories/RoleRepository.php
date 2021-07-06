<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;
use App\Repositories\Abstracts\EloquentRepository;

class RoleRepository extends EloquentRepository implements RoleRepositoryInterface
{
  public function __construct(Role $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Models\Department;
use App\Repositories\Abstracts\EloquentRepository;

class DepartmentRepository extends EloquentRepository implements DepartmentRepositoryInterface
{
  public function __construct(Department $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Models\Admin;
use App\Repositories\Abstracts\EloquentRepository;

class AdminRepository extends EloquentRepository implements AdminRepositoryInterface
{
  public function __construct(Admin $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\Abstracts\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{
  public function __construct(User $model)
  {
    $this->setModel($model);
    $this->setBuilder($model);
  }
}

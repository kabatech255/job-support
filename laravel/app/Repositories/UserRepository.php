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
  }

  /**
   * @param array $memberIds
   * @return string
   */
  public function names(array $memberIds): string
  {
    $members = $this->model()->whereIn('id', $memberIds)->get();
    return implode('、', $members->pluck('full_name')->toArray());
  }
}

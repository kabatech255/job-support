<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProgressRepositoryInterface;
use App\Models\Progress;
use App\Repositories\Abstracts\EloquentRepository;

class ProgressRepository extends EloquentRepository implements ProgressRepositoryInterface
{
  public function __construct(Progress $model)
  {
    $this->setModel($model);
  }
}

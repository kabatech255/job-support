<?php

namespace App\Repositories;

use App\Contracts\Repositories\ActionTypeRepositoryInterface;
use App\Models\ActionType;
use App\Repositories\Abstracts\EloquentRepository;

class ActionTypeRepository extends EloquentRepository implements ActionTypeRepositoryInterface
{
  public function __construct(ActionType $model)
  {
    $this->setModel($model);
  }
}

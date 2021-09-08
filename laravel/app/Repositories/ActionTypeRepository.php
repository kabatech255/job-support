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

  /**
   * Undocumented function
   *
   * @param string $columnName
   * @param $val
   * @return int
   */
  public function findIdBy($val, string $columnName = 'key'): int
  {
    $model = $this->findBy($columnName, $val);
    return $model[0]->id;
  }
}

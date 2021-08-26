<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReactionRepositoryInterface;
use App\Models\Reaction;
use App\Repositories\Abstracts\EloquentRepository;

class ReactionRepository extends EloquentRepository implements ReactionRepositoryInterface
{
  public function __construct(Reaction $model)
  {
    $this->setModel($model);
  }
}

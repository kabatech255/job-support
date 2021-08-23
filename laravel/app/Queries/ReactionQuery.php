<?php

namespace App\Queries;

use App\Contracts\Queries\ReactionQueryInterface;
use App\Models\Reaction;
use App\Queries\Abstracts\EloquentQuery;

class ReactionQuery extends EloquentQuery implements ReactionQueryInterface
{
  public function __construct(Reaction $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

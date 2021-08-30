<?php

namespace App\Queries;

use App\Contracts\Queries\NotifyValidationQueryInterface;
use App\Models\NotifyValidation;
use App\Queries\Abstracts\EloquentQuery;

class NotifyValidationQuery extends EloquentQuery implements NotifyValidationQueryInterface
{
  public function __construct(NotifyValidation $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

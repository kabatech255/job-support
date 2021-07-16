<?php

namespace App\Queries;

use App\Contracts\Queries\TodoQueryInterface;
use App\Queries\Abstracts\EloquentQuery;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Builder;

class TodoQuery extends EloquentQuery implements TodoQueryInterface
{
  public function __construct(Todo $model)
  {
    $this->setBuilder($model);
  }
}

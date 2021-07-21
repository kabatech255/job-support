<?php

namespace App\Queries;

use App\Contracts\Queries\TaskQueryInterface;
use App\Queries\Abstracts\EloquentQuery;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskQuery extends EloquentQuery implements TaskQueryInterface
{
  public function __construct(Task $model)
  {
    $this->setBuilder($model);
    $this->setColumns(['body', 'created_by', 'owner_id', 'status_id', 'progress_id']);
    $this->setRelationTargets([]);
  }
}

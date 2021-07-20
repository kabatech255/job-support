<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\MeetingDecision;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class TaskRepository extends EloquentRepository implements TaskRepositoryInterface
{
  public function __construct(Task $model)
  {
    $this->setModel($model);
  }
}

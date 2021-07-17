<?php

namespace App\Repositories;

use App\Contracts\Repositories\TodoRepositoryInterface;
use App\Models\Todo;
use App\Models\MeetingDecision;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class TodoRepository extends EloquentRepository implements TodoRepositoryInterface
{
  public function __construct(Todo $model)
  {
    $this->setModel($model);
  }
}

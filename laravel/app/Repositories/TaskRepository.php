<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Models\MeetingDecision;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends EloquentRepository implements TaskRepositoryInterface
{
  public function __construct(Task $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $params
   * @param $id
   * @return Model
   */
  public function save(array $params, $id = null): Model
  {
    $params['created_by'] = Auth::user()->id;
    $model = parent::save($params, $id);
    return $model->load($this->model()::RELATIONS_ARRAY);
  }

  public function detach(array $ids)
  {
    return $this->model()->whereIn('id', $ids)->delete();
  }
}

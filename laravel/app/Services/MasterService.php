<?php

namespace App\Services;

use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Database\Eloquent\Model;

class MasterService extends Service
{
  use RepositoryUsingSupport;

  /**
   * @param array $params
   * @return array
   */
  public function all(array $params, array $relation = ['createdBy']): array
  {
    $params['sort_key'] = 'id';
    $params['order_by'] = 'asc';
    return $this->query()->all($params, $relation);
  }

  /**
   * @param array $params
   * @return Model
   */
  public function store(array $params)
  {
    $model = $this->repository()->save($params);
    $model->load(['createdBy']);
    return $model;
  }

  /**
   * @param array $params
   * @param $id
   * @return Model
   */
  public function update(array $params, $id): Model
  {
    $model = $this->repository()->save($params, $id);
    $model->load(['createdBy']);
    return $model;
  }

  /**
   * @param $id
   * @return Model
   */
  public function delete($id): Model
  {
    return $this->repository()->delete($id);
  }
}

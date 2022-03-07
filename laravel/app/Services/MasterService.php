<?php

namespace App\Services;

use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Database\Eloquent\Model;

class MasterService extends Service
{
  use WithRepositoryTrait;

  /**
   * @param array $params
   * @return array
   */
  public function all(array $params): array
  {
    $params['sort_key'] = 'id';
    $params['order_by'] = 'asc';
    return $this->query()->all($params, ['createdBy']);
  }

  /**
   * @param array $params
   * @return Model
   */
  public function store(array $params)
  {
    return $this->repository()->save($params);
  }

  /**
   * @param array $params
   * @param $id
   * @return Model
   */
  public function update(array $params, $id): Model
  {
    return $this->repository()->save($params, $id);
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

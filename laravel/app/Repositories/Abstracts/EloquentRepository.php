<?php

namespace App\Repositories\Abstracts;

use App\Repositories\Traits\ModelTrait as ModelTrait;
use App\Repositories\Traits\BuilderTrait as BuilderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentRepository extends CommonAbstractRepository
{
  use ModelTrait;
  use BuilderTrait;

  /**
   * @return Model|null
   */
  public function save(array $params, $id = null) : Model
  {
    if(!is_null($id)) {
      $model = $this->update($this->qualifiedUpdateParams($this->qualifiedParams($params)), $id);
    } else {
      $model = $this->store($this->qualifiedStoreParams($this->qualifiedParams($params)));
    }
    return $model;
  }

  public function update(array $attributes, $id) : Model
  {
    $model = $this->find($id);

    if ($model) {
      $model->update($attributes);
    }

    return $model;
  }

  public function store(array $attributes) : Model
  {
    return $this->model()->create($attributes);
  }

  /**
   * @return Model
   */
  public function delete($id) : Model
  {
    $model = $this->find($id);

    if ($model) {
      $model->delete();
    }

    return $model;
  }

  /**
   * @return Model
   */
  public function find($id, ?array $loads = []): Model
  {
    if ($id instanceof Model) {
      $model = $id;
    } else {
      $model = $this->model()->findOrFail($id);
    }
    if ($loads && count($loads)) {
      $model->load($loads);
    }
    return $model;
  }

  /**
   * @return Collection
   */
  public function all(): Collection
  {
    return $this->model()->all();
  }
}

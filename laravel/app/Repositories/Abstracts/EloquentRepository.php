<?php

namespace App\Repositories\Abstracts;

use App\Repositories\Traits\ModelTrait as ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

abstract class EloquentRepository extends CommonAbstractRepository
{
  use ModelTrait;

  public function qualifiedStoreParams(array $params): array
  {
    $params['updated_by'] = Auth::check() ? Auth::user()->id : null;
    return parent::qualifiedStoreParams($params);
  }

  public function qualifiedUpdateParams(array $params): array
  {
    $params['updated_by'] = Auth::check() ? Auth::user()->id : null;
    return parent::qualifiedUpdateParams($params);
  }

  /**
   * @return Model|null
   */
  public function save(array $params, $id = null): Model
  {
    if(!is_null($id)) {
      $model = $this->update($this->qualifiedUpdateParams($this->qualifiedParams($params)), $id);
    } else {
      $model = $this->store($this->qualifiedStoreParams($this->qualifiedParams($params)));
    }
    return $model;
  }

  /**
   * @param array $params
   * @param $id
   * @return Model
   */
  public function update(array $params, $id): Model
  {
    $model = $this->find($id);
    if ($model) {
      $model->update($params);
    }
    return $model;
  }

  /**
   * @param array $params
   * @return Model
   */
  public function store(array $params): Model
  {
    return $this->model()->create($params);
  }

  /**
   * @return Model
   */
  public function delete($id): Model
  {
    $model = $this->find($id);
    if ($model) {
      $model->customDelete();
    }
    return $model;
  }

  /**
   * @param array $params
   * @param Model $parent
   * @param string $methodName
   * @param int|null $id
   * @return Model
   */
  public function attach(array $params, Model $parent, string $methodName, int $id = null): Model
  {
    if (method_exists($parent, $methodName)) {
      return $parent->{$methodName}()->updateOrCreate(
        ['id' => $id],
        $this->qualifiedUpdateParams($params)
      );
    }
    return $parent;
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

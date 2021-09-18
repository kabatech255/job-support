<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingRecordPinRepositoryInterface;
use App\Models\MeetingRecordPin;
use App\Repositories\Abstracts\EloquentRepository;

class MeetingRecordPinRepository extends EloquentRepository implements MeetingRecordPinRepositoryInterface
{
  public function __construct(MeetingRecordPin $model)
  {
    $this->setModel($model);
  }

  /**
   * @param int $params
   * @param $model
   * @param string $method
   */
  public function attachPins(int $targetId, $model, string $method)
  {
    if (method_exists($model, $method)) {
      $model->{$method}()->detach($targetId);
      $model->{$method}()->attach($targetId);
    }
    return $model;
  }
  /**
   * @param int $params
   * @param $model
   * @param string $method
   */
  public function detachPins(int $targetId, $model, string $method)
  {
    if (method_exists($model, $method)) {
      $model->{$method}()->detach($targetId);
    }
    return $model;
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingRecordRepositoryInterface;
use App\Models\MeetingRecord;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MeetingRecordRepository extends EloquentRepository implements MeetingRecordRepositoryInterface
{
  public function __construct(MeetingRecord $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $params
   * @param null $id
   * @return Model
   */
  public function saveWithMembers(array $params, $id = null): Model
  {
    $meetingRecord = parent::save($params, $id);
    $meetingRecord->members()->sync($params['members'] ?? []);
    return $meetingRecord;
  }
}

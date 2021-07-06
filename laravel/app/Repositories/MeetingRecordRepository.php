<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingRecordRepositoryInterface;
use App\Models\MeetingRecord;
use App\Repositories\Abstracts\EloquentRepository;

class MeetingRecordRepository extends EloquentRepository implements MeetingRecordRepositoryInterface
{
  public function __construct(MeetingRecord $model)
  {
    $this->setModel($model);
  }
}

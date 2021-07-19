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
}

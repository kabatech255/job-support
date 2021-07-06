<?php

namespace App\Repositories;

use App\Contracts\Repositories\MeetingMemberRepositoryInterface;
use App\Models\MeetingMember;
use App\Repositories\Abstracts\EloquentRepository;

class MeetingMemberRepository extends EloquentRepository implements MeetingMemberRepositoryInterface
{
  public function __construct(MeetingMember $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Services;

use App\Contracts\Queries\MeetingRecordPinQueryInterface as Query;
use App\Contracts\Repositories\MeetingRecordPinRepositoryInterface as Repository;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Contracts\Repositories\MeetingRecordRepositoryInterface as MeetingRecordRepository;
use App\Models\MeetingRecord;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class MeetingRecordPinService extends Service
{
  use WithRepositoryTrait;

  private $userRepository;
  private $meetingRecordRepository;
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   * @param UserRepository $userRepository
   * @param MeetingRecordRepository $meetingRecordRepository
   */
  public function __construct(
    Repository $repository,
    Query $query,
    UserRepository $userRepository,
    MeetingRecordRepository $meetingRecordRepository
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->userRepository = $userRepository;
    $this->meetingRecordRepository = $meetingRecordRepository;
    // else repository...
  }

  public function store($meetingRecordId, array $params)
  {
    if (isset($params['user_id'])) {
      $user = $this->userRepository->find($params['user_id']);
    } else {
      $user = Auth::user();
    }
    $meetingRecord = $this->meetingRecordRepository->find($meetingRecordId);
    return $this->repository()->attachPins($user->id, $meetingRecord, 'pinedUsers');
  }

  public function update($meetingRecordId, array $params)
  {
    if (isset($params['user_id'])) {
      $user = $this->userRepository->find($params['user_id']);
    } else {
      $user = Auth::user();
    }
    $meetingRecord = $this->meetingRecordRepository->find($meetingRecordId);
    return $this->repository()->detachPins($user->id, $meetingRecord, 'pinedUsers');
  }
}

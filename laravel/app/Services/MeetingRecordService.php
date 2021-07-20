<?php

namespace App\Services;

use App\Contracts\Repositories\MeetingRecordRepositoryInterface as Repository;
use App\Contracts\Queries\MeetingRecordQueryInterface as Query;
use App\Models\MeetingDecision;
use App\Services\MeetingDecisionService;
use App\Services\Traits\WithRepositoryTrait;
use App\Models\MeetingRecord;

class MeetingRecordService extends Service
{
  use WithRepositoryTrait;

  protected $meetingDecisionService;
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   * @param MeetingDecisionService $meetingDecisionService,
   */
  public function __construct(
    Repository $repository,
    Query $query,
    MeetingDecisionService $meetingDecisionService
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->meetingDecisionService = $meetingDecisionService;
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @param int|null $perPage
   * @return mixed
   */
  public function paginate(array $params, ?int $perPage = null, ?array $relation = null)
  {
    return $this->query()->paginate($params, $relation, $perPage);
  }

  /**
   * @param int $id
   * @return MeetingRecord
   */
  public function find(int $id): MeetingRecord
  {
    return $this->repository()->find($id, [
      'members',
      'decisions.decidedBy',
      'decisions.writtenBy',
      'decisions.tasks',
      'recordedBy',
      'place',
    ]);
  }

  /**
   * @param array $params
   * @return MeetingRecord
   */
  public function store(array $params): MeetingRecord
  {
    // 議事録の保存
    $meetingRecord = $this->repository()->saveWithMembers($params);
    // 決議事項の保存
    if (isset($params['meeting_decisions'])) {
      foreach($params['meeting_decisions'] as $meetingDecisionParams) {
//        $meetingDecisions[] = $this->saveDecisionByRecord($meetingDecisionParams, $meetingRecord);
        $this->saveDecisionByRecord($meetingDecisionParams, $meetingRecord);
      }
    }
    $meetingRecord->load(['decisions', 'place', 'members', 'recordedBy']);
    return $meetingRecord;
  }

  /**
   * @param array $params
   * @param $id
   * @return MeetingRecord
   */
  public function update(array $params, $id): MeetingRecord
  {
    // 議事録の保存
    $meetingRecord = $this->repository()->saveWithMembers($params, 'members', $id);
    if (isset($params['meeting_decisions'])) {
      foreach ($params['meeting_decisions'] as $meetingDecisionParams) {
        $this->saveDecisionByRecord($meetingDecisionParams, $meetingRecord);
      }
      $meetingRecord->load($this->query()->relation());
    }
    return $meetingRecord;
  }

  /**
   * @param $id
   * @return MeetingRecord
   */
  public function delete($id): MeetingRecord
  {
    return $this->repository()->delete($id);
  }

  /**
   * @param array $meetingDecisionParams
   * @param MeetingRecord $meetingRecord
   * @return MeetingDecision
   */
  private function saveDecisionByRecord(array $meetingDecisionParams, MeetingRecord $meetingRecord): MeetingDecision
  {
    if (isset($meetingDecisionParams['id']) && isset($meetingDecisionParams['flag'])) {
      return $this->meetingDecisionService->updateOrDelete($meetingDecisionParams, $meetingRecord, $meetingDecisionParams['id']);
    } elseif(isset($meetingDecisionParams['id']) && isset($meetingDecisionParams['tasks'])) {
      $meetingDecision = $this->meetingDecisionService->find($meetingDecisionParams['id']);
      return $this->meetingDecisionService->saveTasksByDecision($meetingDecisionParams, $meetingDecision);
    } else {
      return $this->meetingDecisionService->store($meetingDecisionParams, $meetingRecord);
    }
  }
}

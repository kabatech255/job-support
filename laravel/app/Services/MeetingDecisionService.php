<?php

namespace App\Services;

use App\Contracts\Queries\MeetingDecisionQueryInterface as Query;
use App\Contracts\Repositories\MeetingDecisionRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\MeetingRecord;
use App\Models\Todo;
use App\Services\Traits\WithRepositoryTrait;

class MeetingDecisionService extends Service
{
  use WithRepositoryTrait;

  /**
   * @var string
   */
  private $attachMethod = 'decisions';

  /**
   * @var TodoService
   */
  protected $todoService;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   * @param TodoService $todoService
   */

  public function __construct(
    Repository $repository,
    Query $query,
    TodoService $todoService
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->todoService = $todoService;
  }

  /**
   * @param int $id
   * @param array $loads
   * @return MeetingDecision
   */
  public function find(int $id, array $loads = []): MeetingDecision
  {
    return $this->repository()->find($id, $loads);
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @return MeetingDecision
   */
  public function store(array $params, MeetingRecord $meetingRecord): MeetingDecision
  {
    $meetingDecision = $this->repository()->attach($params, $meetingRecord, $this->attachMethod);
    if (isset($params['todos'])) {
      return $this->saveTodosByDecision($params, $meetingDecision);
    }
    return $meetingDecision;
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @param int $id
   * @return MeetingDecision
   */
  public function update(array $params, MeetingRecord $meetingRecord, int $id): MeetingDecision
  {
    $meetingDecision = $this->repository()->attach($params, $meetingRecord, $this->attachMethod, $id);
    if (isset($params['todos'])) {
      return $this->saveTodosByDecision($params, $meetingDecision);
    }
    return $meetingDecision;
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function delete(int $id)
  {
    $deletedDecision = $this->repository()->delete($id);
    if (!!$deletedDecision->todos->count()) {
      $deletedDecision->todos->each(function($todo) {
        $this->todoService->delete($todo->id);
      });
    }
    return $deletedDecision;
  }

  /**
   * @param array $params
   * @param MeetingRecord $meetingRecord
   * @param int $id
   * @return MeetingDecision
   */
  public function updateOrDelete(array $params, MeetingRecord $meetingRecord, int $id): MeetingDecision
  {
    if ($params['flag'] === ProcessFlag::value('delete')) {
      return $this->delete($params['id']);
    }
    return $this->update($params, $meetingRecord, $id);
  }

  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @return MeetingDecision
   */
  public function saveTodosByDecision(array $params, MeetingDecision $meetingDecision): MeetingDecision
  {
    foreach($params['todos'] as $todoParams) {
      $todos[] = $this->saveTodoByDecision($todoParams, $meetingDecision);
    }
    $meetingDecision->load($this->query()->relation());
    return $meetingDecision;
  }

  /**
   * @param array $todoParams
   * @param MeetingDecision $meetingDecision
   * @return Todo
   */
  private function saveTodoByDecision(array $todoParams, MeetingDecision $meetingDecision): Todo
  {
    if (isset($todoParams['id']) && isset($todoParams['flag'])) {
      return $this->todoService->updateOrDelete($todoParams, $meetingDecision, $todoParams['id']);
    } elseif(isset($todoParams['id'])) {
      return $this->todoService->find($todoParams['id']);
    }
    return $this->todoService->store($todoParams, $meetingDecision);
  }
}

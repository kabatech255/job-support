<?php

namespace App\Services;

use App\Contracts\Repositories\TodoRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\MeetingDecision;
use App\Models\Todo;
use App\Services\Traits\WithRepositoryTrait;
use App\Contracts\Queries\TodoQueryInterface as Query;

class TodoService extends Service
{
  use WithRepositoryTrait;

  private $attachMethod = 'todos';

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
  }

  /**
   * @param int $id
   * @param array $loads
   * @return Todo
   */
  public function find(int $id, array $loads = []): Todo
  {
    return $this->repository()->find($id, $loads);
  }


  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @return Todo
   */
  public function store(array $params, MeetingDecision $meetingDecision): Todo
  {
    return $this->repository()->attach($params, $meetingDecision, $this->attachMethod);
  }

  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @param int $id
   * @return Todo
   */
  public function update(array $params, MeetingDecision $meetingDecision, int $id): Todo
  {
    return $this->repository()->attach($params, $meetingDecision, $this->attachMethod, $id);
  }

  /**
   * @param int $id
   * @return Todo
   */
  public function delete(int $id): Todo
  {
    return $this->repository()->delete($id);
  }

  /**
   * @param array $params
   * @param MeetingDecision $meetingDecision
   * @param int $id
   * @return Todo
   */
  public function updateOrDelete(array $params, MeetingDecision $meetingDecision, int $id): Todo
  {
    if ($params['flag'] === ProcessFlag::value('delete')) {
      return $this->delete($id);
    }
    return $this->update($params, $meetingDecision, $id);
  }
}
<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ActionType;
use App\Models\Schedule;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class ScheduleShareActivityJob extends ActivityJob implements ShouldQueue
{
  /**
   * @var Schedule
   */
  protected $model;

  /**
   * @param Schedule $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(Schedule $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::SCHEDULE_SHARED_KEY;
    $this->members = 'sharedMembers';
  }
}

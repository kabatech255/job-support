<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\MeetingPlace;
use App\Models\ActionType;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class MeetingPlaceJoinedActivityJob extends ActivityJob implements ShouldQueue
{
  /**
   * @var MeetingPlace
   */
  protected $model;

  /**
   * @param MeetingPlace $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(MeetingPlace $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::MEETING_PLACE_CREATE_KEY;
  }

  protected function members()
  {
    return [$this->model->createdBy];
  }
}

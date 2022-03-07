<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Progress;
use App\Models\ActionType;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class ProgressCreateActivityJob extends ActivityJob implements ShouldQueue
{
  /**
   * @var Progress
   */
  protected $model;

  /**
   * @param Progress $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(Progress $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::PROGRESS_CREATE_KEY;
  }

  protected function members()
  {
    return [$this->model->createdBy];
  }
}

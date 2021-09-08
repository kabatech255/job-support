<?php

namespace App\Jobs\Supports;

use App\Models\ActionType;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class JobSupport
{
  /**
   * @var ActionTypeRepository
   */
  private $actionTypeRepository;

  /**
   * @var ActivityRepository
   */
  private $activityRepository;

  private $job;
  private $queue;

  public function __construct(ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    $this->actionTypeRepository = $actionTypeRepository;
    $this->activityRepository = $activityRepository;
  }

  public function init($job, $queue = 'default')
  {
    $this->job = $job;
    $this->queue = $queue;
  }

  public function dispatch($model)
  {
    get_class($this->job)::dispatch($model, $this->actionTypeRepository, $this->activityRepository)->onQueue($this->queue);
  }
}

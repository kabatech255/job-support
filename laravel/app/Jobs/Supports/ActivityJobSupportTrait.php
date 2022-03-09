<?php

namespace App\Jobs\Supports;

use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

trait ActivityJobSupportTrait
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
}

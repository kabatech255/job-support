<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Organization;
use App\Models\ActionType;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class OrganizationUpdateActivityJob extends ActivityJob implements ShouldQueue
{
  /**
   * @var Organization
   */
  protected $model;
  protected $bodyLength = 30;

  /**
   * @param Organization $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(Organization $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::ORGANIZATION_UPDATE_KEY;
    $this->bodyKey = ['name'];
  }

  protected function store(array $actionType, string $content)
  {
    $attributes = [
      'action_type_id' => $actionType[0]->id,
      'model_id' => $this->model->id,
      'created_by' => $this->model->updated_by,
      'content' => $content,
    ];
    $this->activityRepository->save($attributes);
  }

  protected function from()
  {
    return $this->model->updatedBy->full_name;
  }
}

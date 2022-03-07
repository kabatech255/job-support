<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ActionType;
use App\Models\ChatMessage;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;

class MessageSentActivityJob extends ActivityJob implements ShouldQueue
{

  /**
   * @var ChatMessage
   */
  protected $model;
  protected $bodyKey = 'body';

  /**
   * @param ChatMessage $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(ChatMessage $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::MESSAGE_SENT_KEY;
    $this->bodyKey = 'body';
  }

  protected function members()
  {
    return $this->model->chatRoom->{$this->members};
  }
}

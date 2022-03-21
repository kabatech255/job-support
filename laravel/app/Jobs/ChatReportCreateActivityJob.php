<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ChatReport;
use App\Models\ActionType;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;
use Illuminate\Support\Facades\Auth;

class ChatReportCreateActivityJob extends ActivityJob implements ShouldQueue
{
  /**
   * @var ChatReport
   */
  protected $model;
  protected $bodyLength = 30;

  /**
   * @param ChatReport $model
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(ChatReport $model, ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    parent::__construct($actionTypeRepository, $activityRepository);
    $this->model = $model;
    $this->actionTypeKey = ActionType::CHAT_REPORT_KEY;
    $this->bodyKey = 'body';
  }

  protected function store(array $actionType, string $content)
  {
    $attributes = [
      'action_type_id' => $actionType[0]->id,
      // 'user_id' => $this->model->chatMessage->created_by,
      'model_id' => $this->model->id,
      'created_by' => $this->model->created_by,
      'content' => $content,
    ];
    $this->activityRepository->save($attributes);
  }

  protected function body()
  {
    $body = $this->model->chatMessage->body;
    return \Str::limit(trim($body), $this->bodyLength, '（...）');
  }
}

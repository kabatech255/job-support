<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\ActivityRepositoryInterface as ActivityRepository;
use App\Services\Supports\StrSupportTrait;
// use App\Models\MeetingRecord;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActionType;

class ActivityJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  use StrSupportTrait;

  /**
   * @var Model
   */
  protected $model;

  protected $members = 'members';

  /**
   * @var ActionTypeRepository
   */
  protected $actionTypeRepository;

  /**
   * @var ActivityRepository
   */
  protected $activityRepository;

  /**
   * @var string
   */
  protected $actionTypeKey = ActionType::MEETING_RECORD_JOINED_KEY;

  /**
   * @var string
   */
  protected $bodyKey = 'title';

  /**
   * @param ActionTypeRepository $actionTypeRepository
   * @param ActivityRepository $activityRepository
   */
  public function __construct(ActionTypeRepository $actionTypeRepository, ActivityRepository $activityRepository)
  {
    $this->actionTypeRepository = $actionTypeRepository;
    $this->activityRepository = $activityRepository;
  }

  /**
   * @return void
   */
  public function handle()
  {
    $actionType = $this->actionTypeRepository->findBy('key', $this->actionTypeKey);
    $content = $this->replaceAttribute($actionType[0]->template_message, [
      'from' => $this->model->createdBy->full_name,
      'body' => \Str::limit($this->model->{$this->bodyKey}, 15, '（...）'),
    ]);
    $this->store($actionType, $content);
  }

  protected function store(array $actionType, string $content)
  {
    $this->members()->each(function ($member) use ($actionType, $content) {
      if ($this->model->created_by !== $member->id) {
        $attributes = [
          'action_type_id' => $actionType[0]->id,
          'model_id' => $this->model->id,
          'user_id' => $member->id,
          'created_by' => $this->model->created_by,
          'content' => $content,
        ];
        $this->activityRepository->save($attributes);
      }
    });
  }

  protected function members()
  {
    return $this->model->{$this->members};
  }
}

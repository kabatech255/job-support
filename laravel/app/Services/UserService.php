<?php

namespace App\Services;

use App\Contracts\Queries\UserQueryInterface as Query;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Contracts\Repositories\NotifyValidationRepositoryInterface as NotifyValidationRepository;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Services\ScheduleService;
use App\Services\MeetingRecordService;
use App\Services\TaskService;
use App\Services\FileUploadService;
use App\Services\Supports\FileSupportTrait;
use App\Services\Supports\StrSupportTrait;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserCreatedNotification;

class UserService extends Service
{
  use WithRepositoryTrait,
    StrSupportTrait,
    FileSupportTrait;

  /**
   * @var NotifyValidationRepository
   */
  private $notifyValidationRepository;
  /**
   * @var ActionTypeRepository
   */
  private $actionTypeRepository;

  private $fileUploadService;
  private $meetingRecordService;
  private $scheduleService;
  private $taskService;

  /**
   * UserService constructor.
   * @param UserRepository $repository
   * @param Query $query
   * @param NotifyValidationRepository $notifyValidationRepository
   * @param ActionTypeRepository $actionTypeRepository
   * @param FileUploadService $fileUploadService
   * @param MeetingRecordService $meetingRecordService
   * @param ScheduleService $scheduleService
   * @param TaskService $taskService
   */
  public function __construct(
    UserRepository $repository,
    Query $query,
    NotifyValidationRepository $notifyValidationRepository,
    ActionTypeRepository $actionTypeRepository,
    FileUploadService $fileUploadService,
    MeetingRecordService $meetingRecordService,
    ScheduleService $scheduleService,
    TaskService $taskService
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->notifyValidationRepository = $notifyValidationRepository;
    $this->actionTypeRepository = $actionTypeRepository;
    $this->fileUploadService = $fileUploadService;
    $this->meetingRecordService = $meetingRecordService;
    $this->scheduleService = $scheduleService;
    $this->taskService = $taskService;
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @return User[]
   */
  public function index(array $params = [], array $relation = []): array
  {
    return $this->query()->all($params, $relation);
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @return User
   */
  public function store(array $params = []): User
  {
    $inviter = Auth::user();
    $params = array_merge($params, [
      'created_by' => $inviter->bUser->id,
      'organization_id' => $inviter->organization_id,
    ]);
    $user = $this->repository()->save($params);

    if ($user) {
      // 登録された人にメール通知
      Notification::send([$user], new UserCreatedNotification($inviter));
    }

    return $user;
  }

  /**
   * @param array $params
   * @param $id
   * @return User
   */
  public function updateProfile(array $params, $id): User
  {
    if (isset($params['file'])) {
      $user = $this->repository()->find($id);
      $params = $this->fileUpload($params, $user, 'id', $this->repository()->findPath($id));
    }
    // $params['delete_flag']が"'0'"の場合スルーしたいため、isset(...)を使わない
    if (!empty($params['delete_flag'] ?? '') && !!$this->repository()->findPath($id)) {
      $this->fileUploadService->remove($this->repository()->findPath($id));
      $params['file_path'] = null;
    }
    if (isset($params['family_name_kana'])) {
      // mode = "KV"
      $params['family_name_kana'] = mb_convert_kana($this->mbTrim($params['family_name_kana']));
    }
    if (isset($params['given_name_kana'])) {
      // mode = "KV"
      $params['given_name_kana'] = mb_convert_kana($this->mbTrim($params['given_name_kana']));
    }
    return $this->repository()->update($params, $id);
  }

  /**
   * @param array $params
   * @param $id
   * @return User
   */
  public function updateSetting(array $params, $id): User
  {
    if (isset($params['notify_validation'])) {
      $user = $this->repository()->find($id);
      $notifyValidations = [];
      foreach ($params['notify_validation'] as $key => $val) {
        $validationParam = [
          'action_type_id' => (int)$key,
          'is_valid' => (int)$val,
        ];
        $notifyValidations[] = $this->notifyValidationRepository->attachByUser($validationParam, $user, $key);
      }
    }
    return $this->repository()->update($params, $id);
  }

  /**
   * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function currentUser()
  {
    // 未認証の場合はnullが返ってくる
    $author = Auth::user();
    return $author;
  }

  /**
   * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function withChatRooms()
  {
    // 未認証の場合はnullが返ってくる
    $user = Auth::user();
    if (!!$user) {
      $withChatRoom = $this->repository()->find($user->id);
      $withChatRoom->load(['chatRooms.members', 'chatRooms.lastReads']);
      // ルームごとの既読情報を認証者のレコードだけ抜き出す
      $withChatRoom->chatRooms->each(function ($chatRoom) {
        $index = $chatRoom->lastReads->search(function ($lastRead) {
          return $lastRead->member_id === Auth::user()->id;
        }, true);
        if ($index !== false) {
          $chatRoom->lastReads->splice($index, 1);
        }
      });
      return $withChatRoom;
    }
    return $user;
  }

  public function notifyStatus($id)
  {
    $user = $this->repository()->find($id);
    if ($user->notifyValidations->count() === 0) {
      return $this->newValidations();
    }
    return $user->notifyValidations->map(function ($notifyValidation) {
      return [
        'id' => $notifyValidation->actionType->id,
        'key' => $notifyValidation->actionType->key,
        'label_name' => $notifyValidation->actionType->label_name,
        'is_valid' => $notifyValidation->is_valid,
      ];
    })->all();
  }

  private function newValidations()
  {
    return $this->actionTypeRepository->all()->map(function ($actionType) {
      return [
        'id' => $actionType->id,
        'key' => $actionType->key,
        'label_name' => $actionType->label_name,
        'is_valid' => false,
      ];
    })->all();
  }
}

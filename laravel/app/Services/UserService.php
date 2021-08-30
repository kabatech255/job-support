<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Contracts\Repositories\NotifyValidationRepositoryInterface as NotifyValidationRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\Traits\FileSupportTrait;
use App\Services\Traits\StrSupportTrait;

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
   * @var FileUploadService
   */
  private $fileUploadService;

  /**
   * UserService constructor.
   * @param UserRepository $repository
   */
  public function __construct(
    UserRepository $repository,
    NotifyValidationRepository $notifyValidationRepository,
    FileUploadService $fileUploadService
  ) {
    $this->setRepository($repository);
    $this->notifyValidationRepository = $notifyValidationRepository;
    $this->fileUploadService = $fileUploadService;
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
   * @return Collection
   */
  public function all(): Collection
  {
    return $this->repository()->all();
  }

  /**
   * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function currentUser()
  {
    // 未認証の場合はnullが返ってくる
    return Auth::user();
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
    return $user->notifyValidations->map(function ($notifyValidation) {
      return [
        'id' => $notifyValidation->actionType->id,
        'key' => $notifyValidation->actionType->key,
        'name' => $notifyValidation->actionType->name,
        'is_valid' => $notifyValidation->is_valid,
      ];
    })->all();
  }
}

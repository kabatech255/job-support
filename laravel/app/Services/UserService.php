<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\Traits\FileSupportTrait;

class UserService extends Service
{
  use WithRepositoryTrait,
    FileSupportTrait;

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
    FileUploadService $fileUploadService
  ) {
    $this->setRepository($repository);
    $this->fileUploadService = $fileUploadService;
  }

  /**
   * @param array $params
   * @param $id
   * @return User
   */
  public function update(array $params, $id): User
  {
    if (isset($params['file'])) {
      $user = $this->repository()->find($id);
      $params = $this->fileUpload($params, $user, 'id', $this->repository()->findPath($id));
    }
    // $params['delete_flag']が'0'の場合スルーしたいため、isset(...)を使わない
    if (!empty($params['delete_flag'] ?? '') && !!$this->repository()->findPath($id)) {
      $this->fileUploadService->remove($this->repository()->findPath($id));
      $params['file_path'] = null;
    }
    return $this->repository()->updateProfile($params, $id);
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
      $withChatRoom->load(['chatRooms.members']);
      return $withChatRoom;
    }
    return $user;
  }
}

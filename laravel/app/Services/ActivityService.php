<?php

namespace App\Services;

use App\Contracts\Queries\ActivityQueryInterface as Query;
use App\Contracts\Repositories\ActivityRepositoryInterface as Repository;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Contracts\Repositories\AdminRepositoryInterface as AdminRepository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin;

class ActivityService extends Service
{
  use WithRepositoryTrait;

  private $userRepository;
  private $adminRepository;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param UserRepository $userRepository
   * @param AdminRepository $adminRepository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    UserRepository $userRepository,
    AdminRepository $adminRepository,
    Query $query
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->userRepository = $userRepository;
    $this->adminRepository = $adminRepository;
  }

  /**
   * Undocumented function
   *
   * @param integer|null $userId
   * @return array
   */
  public function findByUser(?int $userId = null): array
  {
    if (is_null($userId)) {
      $userId = Auth::user()->id;
    }
    return $this->query()->limitOfUser(10, [
      'user_id' => $userId,
    ]);
  }

  public function read($userId)
  {
    if ($userId instanceof Model) {
      $userId = $userId->id;
    }

    return $this->repository()->read($userId);
  }

  /**
   * @param array $params
   * @param User|int $userId
   */
  public function findByCreatedUser(array $params, $userId)
  {
    if ($userId instanceof User) {
      $createdBy = $userId;
    } else {
      $createdBy = $this->userRepository->find($userId);
    }
    $activities = $this->repository()->findBy('created_by', $createdBy->id, ['createdBy']);
    $sorted = collect($activities)->sortByDesc('id');
    return $sorted->values()->all();
  }
}

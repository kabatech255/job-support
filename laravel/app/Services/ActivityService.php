<?php

namespace App\Services;

use App\Contracts\Queries\ActivityQueryInterface as Query;
use App\Contracts\Repositories\ActivityRepositoryInterface as Repository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    // else repository...
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
}

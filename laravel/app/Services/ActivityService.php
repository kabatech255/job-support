<?php

namespace App\Services;

use App\Contracts\Queries\ActivityQueryInterface as Query;
use App\Contracts\Repositories\ActivityRepositoryInterface as Repository;
use App\Contracts\Repositories\ActionTypeRepositoryInterface as ActionTypeRepository;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use App\Contracts\Repositories\AdminRepositoryInterface as AdminRepository;
use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class ActivityService extends Service
{
  use RepositoryUsingSupport;

  private $actionTypeRepository;
  private $userRepository;
  private $adminRepository;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param ActionTypeRepository $actionTypeRepository
   * @param UserRepository $userRepository
   * @param AdminRepository $adminRepository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    ActionTypeRepository $actionTypeRepository,
    UserRepository $userRepository,
    AdminRepository $adminRepository,
    Query $query
  ) {
    $this->setRepository($repository);
    $this->actionTypeRepository = $actionTypeRepository;
    $this->userRepository = $userRepository;
    $this->adminRepository = $adminRepository;
    $this->setQuery($query);
  }

  /**
   * @param array $params
   * @return array
   */
  public function limit(array $params)
  {
    $oldestDate = Carbon::parse('-1 year')->format('Y-m-d');
    $limit = $params['limit'] ?? 20;
    return Activity::with(['createdBy'])
      ->whereHas('createdBy', function ($q) use ($params) {
        $q->where('organization_id', $params['createdBy:organization_id']);
      })
      ->whereDate('created_at', '>', $oldestDate)
      ->groupBy('action_type_id', 'model_id')
      ->orderBy('id', 'desc')
      ->limit($limit)
      ->get();
  }

  /**
   * @param integer|null $userId
   * @return array
   */
  public function findByUser(?int $userId = null): array
  {
    if (is_null($userId)) {
      $userId = Auth::user()->id;
    }
    $actionTypeIds = $this->actionTypeRepository->idsByAuthenticatable();
    return $this->query()->maxRecordsForUser(10, [
      'user_id' => $userId,
      'action_type_ids' => $actionTypeIds,
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
   * @return array
   */
  public function findByCreatedUser(array $params, $userId)
  {
    if ($userId instanceof User) {
      $createdBy = $userId;
    } else {
      $createdBy = $this->userRepository->find($userId);
    }

    $actionTypeIds = $this->actionTypeRepository->idsByAuthenticatable($params['authenticatable']);
    $activities = $this->query()->findByCreatedUserAndActionType([
      'created_by' => $createdBy->id,
      'action_type_ids' => $actionTypeIds,
      // 'offset' => $params['offset'],
    ]);

    if ($params['authenticatable'] === 'user') {
      $activities = $this->bundleActivities($activities);
    }

    $maxPage = ceil($activities->count() / 10);

    return [
      'activities' => $activities->forPage($params['page'], 10)->values()->all(),
      'hasMore' => !($maxPage == 0 || ceil($activities->count() / 10) == $params['page'])
    ];
  }

  /**
   * @param Collection $activities
   * @return Collection
   */
  protected function bundleActivities($activities)
  {
    $groupedByActionType = collect($activities)->groupBy('action_type_id');

    return $groupedByActionType->flatMap(function ($activities) {
      $grouped = $activities->groupBy('model_id');
      return $grouped->map(function ($activities) {
        return $activities->first();
      });
    });
  }
}

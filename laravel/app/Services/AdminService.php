<?php

namespace App\Services;

use App\Contracts\Repositories\AdminRepositoryInterface as Repository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use App\Queries\AdminQuery as Query;
use App\Models\Admin;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminCreatedNotification;

class AdminService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param Repository $repository
   */
  public function __construct(Repository $repository, Query $query)
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    // else repository...
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @return Admin[]
   */
  public function index(array $params = [], array $relation = []): array
  {
    return $this->query()->all($params, $relation);
  }

  /**
   * @param array $params
   * @return Admin
   */
  public function store(array $params = []): Admin
  {
    $inviter = Auth::user();
    $params = array_merge($params, [
      'organization_id' => $inviter->organization_id,
    ]);
    $admin = $this->repository()->save($params);

    if ($admin) {
      // 登録された人にメール通知
      Notification::send([$admin], new AdminCreatedNotification($inviter));
    }

    return $admin;
  }

  /**
   * @param Admin|int $id
   * @param array $loads
   * @return Admin
   */
  public function find($id, array $loads = ['department']): Admin
  {
    return $this->repository()->find($id, $loads);
  }

  /**
   * @return \Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function currentAdmin()
  {
    // 未認証の場合はnullが返ってくる
    return Auth::guard('admin')->user();
  }
}

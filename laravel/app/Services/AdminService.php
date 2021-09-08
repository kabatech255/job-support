<?php

namespace App\Services;

use App\Contracts\Repositories\AdminRepositoryInterface as Repository;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class AdminService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param Repository $repository
   */
  public function __construct(Repository $repository)
  {
    $this->setRepository($repository);
    // else repository...
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

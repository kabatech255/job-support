<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Traits\WithRepositoryTrait;

class UserService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param UserRepository $repository
   */
  public function __construct(UserRepository $repository)
  {
    $this->setRepository($repository);
    // else repository...
  }

  /**
   * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
   */
  public function currentUser()
  {
    // 未認証の場合はnullが返ってくる
    return Auth::user();
  }
}

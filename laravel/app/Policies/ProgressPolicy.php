<?php

namespace App\Policies;

use App\Models\Progress;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgressPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any models.
   *
   * @param  Authenticatable  $user
   * @return mixed
   */
  public function viewAny(Authenticatable $user)
  {
    return true;
  }

  /**
   * Determine whether the user can view the model.
   *
   * @param  Authenticatable  $user
   * @param  \App\Models\Progress  $progress
   * @return mixed
   */
  public function view(Authenticatable $user, Progress $progress)
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   *
   * @param  Authenticatable  $user
   * @return mixed
   */
  public function create(Authenticatable $user)
  {
    //
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param  Authenticatable  $user
   * @param  \App\Models\Progress  $progress
   * @return mixed
   */
  public function update(Authenticatable $user, Progress $progress)
  {
    // デフォルト値は更新できない
    return !$progress->is_default;
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param  Authenticatable  $user
   * @param  \App\Models\Progress  $progress
   * @return mixed
   */
  public function delete(Authenticatable $user, Progress $progress)
  {
    // デフォルト値は削除できない
    return !$progress->is_default;
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @param  Authenticatable  $user
   * @param  \App\Models\Progress  $progress
   * @return mixed
   */
  public function restore(Authenticatable $user, Progress $progress)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @param  Authenticatable  $user
   * @param  \App\Models\Progress  $progress
   * @return mixed
   */
  public function forceDelete(Authenticatable $user, Progress $progress)
  {
    //
  }
}

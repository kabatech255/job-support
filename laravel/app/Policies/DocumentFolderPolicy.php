<?php

namespace App\Policies;

use App\Models\DocumentFolder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentFolderPolicy
{
  use HandlesAuthorization;

  /**
   * Determine whether the user can view any models.
   *
   * @param \App\Models\User $user
   * @return mixed
   */
  public function viewAny(User $user)
  {
    return true;
  }

  /**
   * Determine whether the user can view the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\DocumentFolder $documentFolder
   * @return mixed
   */
  public function view(User $user, DocumentFolder $documentFolder)
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   *
   * @param \App\Models\User $user
   * @return mixed
   */
  public function create(User $user)
  {
    return true;
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\DocumentFolder $documentFolder
   * @return mixed
   */
  public function update(User $user, DocumentFolder $documentFolder)
  {
    return $documentFolder->created_by === $user->id;
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\DocumentFolder $documentFolder
   * @return mixed
   */
  public function delete(User $user, DocumentFolder $documentFolder)
  {
    return $documentFolder->created_by === $user->id;
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\DocumentFolder $documentFolder
   * @return mixed
   */
  public function restore(User $user, DocumentFolder $documentFolder)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\DocumentFolder $documentFolder
   * @return mixed
   */
  public function forceDelete(User $user, DocumentFolder $documentFolder)
  {
    //
  }
}

<?php

namespace App\Policies;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatMessagePolicy
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
    //
  }

  /**
   * Determine whether the user can view the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatMessage $chatMessage
   * @return mixed
   */
  public function view(User $user, ChatMessage $chatMessage)
  {
    //
  }

  /**
   * Determine whether the user can create models.
   *
   * @param \App\Models\User $user
   * @return mixed
   */
  public function create(User $user)
  {
    //
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatMessage $chatMessage
   * @return mixed
   */
  public function update(User $user, ChatMessage $chatMessage)
  {
    return $chatMessage->written_by === $user->id;
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatMessage $chatMessage
   * @return mixed
   */
  public function delete(User $user, ChatMessage $chatMessage)
  {
    return $chatMessage->written_by === $user->id;
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatMessage $chatMessage
   * @return mixed
   */
  public function restore(User $user, ChatMessage $chatMessage)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatMessage $chatMessage
   * @return mixed
   */
  public function forceDelete(User $user, ChatMessage $chatMessage)
  {
    //
  }
}
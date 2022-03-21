<?php

namespace App\Policies;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatRoomPolicy
{
  use HandlesAuthorization;
  /**
   * Determine whether the user can view the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function view(User $user, ChatRoom $chatRoom)
  {
    $member = $chatRoom->members->find($user->id);
    return $member;
  }

  /**
   * Determine whether the user can create models.
   *
   * @param \App\Models\User $user
   * @return mixed
   */
  public function create(User $user)
  {
    return $user;
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function update(User $user, ChatRoom $chatRoom)
  {
    $member = $chatRoom->members->find($user->id);
    return $member && $member->option->is_editable;
  }

  /**
   * Determine whether the user can update the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function report(User $user, ChatRoom $chatRoom)
  {
    return $chatRoom->members->contains(function ($member) use ($user) {
      return $member->id === $user->id;
    });
  }

  /**
   * Determine whether the user can delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function delete(User $user, ChatRoom $chatRoom)
  {
    $member = $chatRoom->members->find($user->id);
    return $member && $member->option->is_editable;
  }

  public function storeMessage(User $user, ChatRoom $chatRoom)
  {
    return $chatRoom->members->find($user->id);
  }

  /**
   * Determine whether the user can restore the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function restore(User $user, ChatRoom $chatRoom)
  {
    //
  }

  /**
   * Determine whether the user can permanently delete the model.
   *
   * @param \App\Models\User $user
   * @param \App\Models\ChatRoom $chatRoom
   * @return mixed
   */
  public function forceDelete(User $user, ChatRoom $chatRoom)
  {
    //
  }
}

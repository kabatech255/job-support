<?php

namespace App\Services;

use App\Contracts\Repositories\ChatRoomRepositoryInterface as Repository;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class ChatRoomService extends Service
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
   * @return array
   */
  public function findByOwner()
  {
    $author = Auth::user();
    if (!!$author) {
      $loads = [
        'members',
        'messages.writtenBy',
        'messages.to',
        'messages.writtenBy',
        'messages.images',
      ];
      $chatRooms = $author->chatRooms;
      $chatRooms->load($loads);
      return $chatRooms;
    }
    return [];
  }
}

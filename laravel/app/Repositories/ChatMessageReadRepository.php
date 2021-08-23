<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatMessageReadRepositoryInterface;
use App\Models\ChatMessageRead;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatMessageReadRepository extends EloquentRepository implements ChatMessageReadRepositoryInterface
{
  public function __construct(ChatMessageRead $model)
  {
    $this->setModel($model);
  }

  /**
   * @param int $userId
   * @param array $chatMessageIds
   * @return void
   */
  public function read(int $userId, array $chatMessageIds)
  {
    $member = User::find($userId);
    if (!!$member) {
      $member->chatMessageReads()->detach($chatMessageIds);
      $member->chatMessageReads()->attach($chatMessageIds);
    }
  }
}

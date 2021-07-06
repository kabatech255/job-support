<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatRoomRepositoryInterface;
use App\Models\ChatRoom;
use App\Repositories\Abstracts\EloquentRepository;

class ChatRoomRepository extends EloquentRepository implements ChatRoomRepositoryInterface
{
  public function __construct(ChatRoom $model)
  {
    $this->setModel($model);
  }
}

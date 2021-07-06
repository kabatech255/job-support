<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatRoomShareRepositoryInterface;
use App\Models\ChatRoomShare;
use App\Repositories\Abstracts\EloquentRepository;

class ChatRoomShareRepository extends EloquentRepository implements ChatRoomShareRepositoryInterface
{
  public function __construct(ChatRoomShare $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Queries;

use App\Contracts\Queries\ChatRoomQueryInterface;
use App\Models\ChatRoom;
use App\Queries\Abstracts\EloquentQuery;

class ChatRoomQuery extends EloquentQuery implements ChatRoomQueryInterface
{
  public function __construct(ChatRoom $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

<?php

namespace App\Queries;

use App\Contracts\Queries\ChatRoomShareQueryInterface;
use App\Models\ChatRoomShare;
use App\Queries\Abstracts\EloquentQuery;

class ChatRoomShareQuery extends EloquentQuery implements ChatRoomShareQueryInterface
{
  public function __construct(ChatRoomShare $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

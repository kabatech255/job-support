<?php

namespace App\Queries;

use App\Contracts\Queries\ChatMessageReadQueryInterface;
use App\Models\ChatMessageRead;
use App\Queries\Abstracts\EloquentQuery;

class ChatMessageReadQuery extends EloquentQuery implements ChatMessageReadQueryInterface
{
  public function __construct(ChatMessageRead $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

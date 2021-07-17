<?php

namespace App\Queries;

use App\Contracts\Queries\ChatMessageQueryInterface;
use App\Models\ChatMessage;
use App\Queries\Abstracts\EloquentQuery;

class ChatMessageQuery extends EloquentQuery implements ChatMessageQueryInterface
{
  public function __construct(ChatMessage $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

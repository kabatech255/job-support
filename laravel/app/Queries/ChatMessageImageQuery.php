<?php

namespace App\Queries;

use App\Contracts\Queries\ChatMessageImageQueryInterface;
use App\Models\ChatMessageImage;
use App\Queries\Abstracts\EloquentQuery;

class ChatMessageImageQuery extends EloquentQuery implements ChatMessageImageQueryInterface
{
  public function __construct(ChatMessageImage $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

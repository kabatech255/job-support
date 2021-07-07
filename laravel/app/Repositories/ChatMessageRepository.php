<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatMessageRepositoryInterface;
use App\Models\ChatMessage;
use App\Repositories\Abstracts\EloquentRepository;

class ChatMessageRepository extends EloquentRepository implements ChatMessageRepositoryInterface
{
  public function __construct(ChatMessage $model)
  {
    $this->setModel($model);
  }
}

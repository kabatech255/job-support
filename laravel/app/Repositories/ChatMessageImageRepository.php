<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatMessageImageRepositoryInterface;
use App\Models\ChatMessageImage;
use App\Repositories\Abstracts\EloquentRepository;

class ChatMessageImageRepository extends EloquentRepository implements ChatMessageImageRepositoryInterface
{
  public function __construct(ChatMessageImage $model)
  {
    $this->setModel($model);
  }

  /**
   * @param $id
   * @return string | null
   */
  public function findPath($id): ?string
  {
    if ($id instanceof ChatMessageImage) {
      return $id->file_path;
    }
    return parent::find($id)->file_path;
  }
}

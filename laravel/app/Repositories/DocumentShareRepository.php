<?php

namespace App\Repositories;

use App\Contracts\Repositories\DocumentShareRepositoryInterface;
use App\Models\DocumentShare;
use App\Repositories\Abstracts\EloquentRepository;

class DocumentShareRepository extends EloquentRepository implements DocumentShareRepositoryInterface
{
  public function __construct(DocumentShare $model)
  {
    $this->setModel($model);
  }
}

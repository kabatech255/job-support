<?php

namespace App\Repositories;

use App\Contracts\Repositories\DocumentFileRepositoryInterface;
use App\Models\DocumentFile;
use App\Repositories\Abstracts\EloquentRepository;

class DocumentFileRepository extends EloquentRepository implements DocumentFileRepositoryInterface
{
  public function __construct(DocumentFile $model)
  {
    $this->setModel($model);
  }
}

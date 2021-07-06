<?php

namespace App\Repositories;

use App\Contracts\Repositories\DocumentFolderRepositoryInterface;
use App\Models\DocumentFolder;
use App\Repositories\Abstracts\EloquentRepository;

class DocumentFolderRepository extends EloquentRepository implements DocumentFolderRepositoryInterface
{
  public function __construct(DocumentFolder $model)
  {
    $this->setModel($model);
  }
}

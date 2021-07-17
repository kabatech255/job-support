<?php

namespace App\Queries;

use App\Contracts\Queries\DocumentFolderQueryInterface;
use App\Models\DocumentFolder;
use App\Queries\Abstracts\EloquentQuery;

class DocumentFolderQuery extends EloquentQuery implements DocumentFolderQueryInterface
{
  public function __construct(DocumentFolder $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

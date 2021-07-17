<?php

namespace App\Queries;

use App\Contracts\Queries\DocumentShareQueryInterface;
use App\Models\DocumentShare;
use App\Queries\Abstracts\EloquentQuery;

class DocumentShareQuery extends EloquentQuery implements DocumentShareQueryInterface
{
  public function __construct(DocumentShare $model)
  {
    $this->setBuilder($model);
    $this->setColumns([]);
    $this->setRelationTargets([]);
  }
}

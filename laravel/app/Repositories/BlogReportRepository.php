<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogReportRepositoryInterface;
use App\Models\BlogReport;
use App\Repositories\Abstracts\EloquentRepository;

class BlogReportRepository extends EloquentRepository implements BlogReportRepositoryInterface
{
  public function __construct(BlogReport $model)
  {
    $this->setModel($model);
  }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReportCategoryRepositoryInterface;
use App\Models\ReportCategory;
use App\Repositories\Abstracts\EloquentRepository;

class ReportCategoryRepository extends EloquentRepository implements ReportCategoryRepositoryInterface
{
  public function __construct(ReportCategory $model)
  {
    $this->setModel($model);
  }
}

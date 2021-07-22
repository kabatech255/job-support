<?php

namespace App\Repositories;

use App\Contracts\Repositories\BlogImageRepositoryInterface;
use App\Models\BlogImage;
use App\Repositories\Abstracts\EloquentRepository;

class BlogImageRepository extends EloquentRepository implements BlogImageRepositoryInterface
{
  public function __construct(BlogImage $model)
  {
    $this->setModel($model);
  }

  /**
   * @param $id
   * @return string
   */
  public function findPath($id): string
  {
    if ($id instanceof BlogImage) {
      return $id->file_path;
    }
    return parent::find($id)->file_path;
  }
}

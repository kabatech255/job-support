<?php

namespace App\Repositories;

use App\Contracts\Repositories\DocumentFolderRepositoryInterface;
use App\Models\DocumentFolder;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class DocumentFolderRepository extends EloquentRepository implements DocumentFolderRepositoryInterface
{
  public function __construct(DocumentFolder $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $params
   * @param null $id
   * @return Model
   */
  public function save(array $params, $id = null): Model
  {
    $model = parent::save($params, $id);
    return $model->load(DocumentFolder::RELATIONS_ARRAY);
  }
}

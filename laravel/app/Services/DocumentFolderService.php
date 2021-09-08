<?php

namespace App\Services;

use App\Contracts\Queries\DocumentFolderQueryInterface as Query;
use App\Contracts\Repositories\DocumentFolderRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Models\DocumentFolder;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class DocumentFolderService extends Service
{
  use WithRepositoryTrait;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @return mixed
   */
  public function index(array $params, ?array $relation = null)
  {
    return $this->query()->all($params, $relation);
  }

  /**
   * @param int $id
   * @param array $loads
   * @return DocumentFolder
   */
  public function find(int $id, array $loads = []): DocumentFolder
  {
    return $this->repository()->find($id, $loads);
  }


  /**
   * @param array $params
   * @return DocumentFolder
   */
  public function store(array $params): DocumentFolder
  {
    return $this->repository()->save($params);
  }

  /**
   * @param array $params
   * @param $id
   * @return DocumentFolder
   */
  public function update(array $params, $id): DocumentFolder
  {
    return $this->repository()->save($params, $id);
  }

  /**
   * @param $id
   * @return DocumentFolder
   */
  public function delete($id): DocumentFolder
  {
    return $this->repository()->delete($id);
  }
}

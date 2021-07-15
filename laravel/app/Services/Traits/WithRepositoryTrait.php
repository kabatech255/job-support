<?php

namespace App\Services\Traits;

use App\Contracts\Repositories\RepositoryInterface as Repository;
use App\Contracts\Queries\QueryInterface as Query;

trait WithRepositoryTrait
{
  private $repository;
  private $query;

  protected function setRepository(Repository $repository)
  {
    $this->repository = $repository;
  }

  protected function setQuery(Query $query)
  {
    $this->query = $query;
  }

  public function repository()
  {
    return $this->repository;
  }

  public function query()
  {
    return $this->query;
  }
}

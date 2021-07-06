<?php

namespace App\Services\Traits;

use App\Contracts\Repositories\RepositoryInterface as Repository;

trait WithRepositoryTrait
{
  private $repository;

  protected function setRepository(Repository $repository)
  {
    $this->repository = $repository;
  }

  public function repository()
  {
    return $this->repository;
  }
}

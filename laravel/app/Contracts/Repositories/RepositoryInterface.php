<?php
namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
  /**
   * @return Model
   */
  public function save(array $inputs, $id = null): Model;

  /**
   * @return Model
   */
  public function update(array $inputs, $id): Model;

  /**
   * @return Model
   */
  public function store(array $inputs): Model;

  /**
   * @return Model
   */
  public function delete($id): Model;

  /**
   * @return Model
   */
  public function find($id, ?array $loads = []): Model;

  /**
   * @return Collection
   */
  public function all(): Collection;
}

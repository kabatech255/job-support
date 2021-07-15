<?php
namespace App\Contracts\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface QueryInterface
{
  public function search(array $params, array $relation = []);
  public function paginate(array $params, array $relation = null, int $perPage = null);
}

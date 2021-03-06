<?php

namespace App\Contracts\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QueryInterface
{
  public function search(array $params, array $relation = []);
  public function paginate(array $params, int $perPage = null, array $relation = null): LengthAwarePaginator;
}

<?php

namespace App\Services;

use App\Contracts\Queries\ChatReportQueryInterface as Query;
use App\Contracts\Repositories\ChatReportRepositoryInterface as Repository;
use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Facades\Auth;

class ChatReportService extends Service
{
  use RepositoryUsingSupport;

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
    // else repository...
  }

  /**
   * @return array
   */
  public function index(array $params, $relation = ['createdBy', 'chatMessage.chatRoom', 'chatMessage.createdBy', 'reportCategory'])
  {
    $chatReports = $this->query()->all($params, $relation);
    return collect($chatReports)->map(function ($chatReport) {
      $chatReport->chatMessage->dot_body = \Str::limit($chatReport->chatMessage->body, 20, '...');
      return $chatReport;
    })->all();
  }
}

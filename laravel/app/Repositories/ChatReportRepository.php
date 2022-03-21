<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatReportRepositoryInterface;
use App\Models\ChatReport;
use App\Repositories\Abstracts\EloquentRepository;

class ChatReportRepository extends EloquentRepository implements ChatReportRepositoryInterface
{
  public function __construct(ChatReport $model)
  {
    $this->setModel($model);
  }

  /**
   * Undocumented function
   *
   * @param array $params
   * @return ChatReport
   */
  public function single(array $params): ChatReport
  {
    $chatReport = $this->model()
      ->where('chat_message_id', $params['chat_message_id'])
      ->where('created_by', $params['created_by'])
      ->first();
    // $chatReport->load(['createdBy', 'chatMessage', 'reportCategory']);
    return $chatReport;
  }
}

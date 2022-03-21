<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatMessageRepositoryInterface;
use App\Models\ChatMessage;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChatMessageRepository extends EloquentRepository implements ChatMessageRepositoryInterface
{
  public function __construct(ChatMessage $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $params
   * @param Model $parent
   * @param string $method
   * @param null $id
   * @return Model
   */
  public function attach(array $params, Model $parent, string $method, $id = null): Model
  {
    $params['created_by'] = Auth::user()->id;
    $chatMessage = parent::attach($params, $parent, $method, $id);
    // $chatMessage->load(['createdBy', 'to', 'chatMessageReads', 'images']);
    return $chatMessage;
  }

  /**
   * @param array $params
   * @param ChatMessage|int $chatMessage
   * @return ChatMessage
   */
  public function report(array $params, $id): ChatMessage
  {
    $createdBy = Auth::user()->id;
    $chatMessage = $this->find($id);
    $chatMessage->chatReports()->detach($createdBy);
    $chatMessage->chatReports()->attach($createdBy, [
      'report_category_id' => $params['report_category_id']
    ]);
    return $chatMessage;
  }
}

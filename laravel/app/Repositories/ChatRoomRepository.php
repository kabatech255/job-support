<?php

namespace App\Repositories;

use App\Contracts\Repositories\ChatRoomRepositoryInterface;
use App\Models\ChatRoom;
use App\Repositories\Abstracts\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChatRoomRepository extends EloquentRepository implements ChatRoomRepositoryInterface
{
  public function __construct(ChatRoom $model)
  {
    $this->setModel($model);
  }

  /**
   * @param array $params
   * @param string $method
   * @param null $id
   * @return Model
   */
  public function saveWithMembers(array $params, string $method = 'members', $id = null): Model
  {
    if (is_null($id)) {
      $params['created_by'] = Auth::user()->id;
    }
    $chatRoom = parent::saveWithMembers($params, $method, $id);
    $chatRoom->load(ChatRoom::RELATIONS_ARRAY);
    return $chatRoom;
  }

  public function findLastMessageId($chatRoomId): array
  {
    $chatRoom = $this->find($chatRoomId);
    $targetRead = $chatRoom->lastReads->where('member_id', Auth::user()->id)->first();
    if ($targetRead) {
      return [$chatRoom, $targetRead->last_message_id];
    }
    return  [$chatRoom, 0];
  }
}

<?php

namespace App\Services;

use App\Contracts\Queries\ChatMessageQueryInterface as Query;
use App\Contracts\Repositories\ChatMessageRepositoryInterface as Repository;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class ChatMessageService extends Service
{
  use WithRepositoryTrait;
  /**
   * @var string
   */
  private $attachMethod = 'messages';
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
  }

  /**
   * @param array $params
   * @param ChatRoom $chatRoom
   * @return ChatMessage
   */
  public function store(array $params, ChatRoom $chatRoom): ChatMessage
  {
    return $this->repository()->attach($params, $chatRoom, $this->attachMethod);
  }

  /**
   * @param array $params
   * @param ChatRoom $chatRoom
   * @param $id
   * @return ChatMessage
   */
  public function update(array $params, ChatRoom $chatRoom, $id): ChatMessage
  {
    return $this->repository()->attach($params, $chatRoom, $this->attachMethod, $id);
  }

  /**
   * @param $id
   * @return ChatMessage
   */
  public function delete($id): ChatMessage
  {
    return $this->repository()->delete($id);
  }

}

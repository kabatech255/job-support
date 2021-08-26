<?php

namespace App\Services;

use App\Contracts\Queries\ChatMessageReadQueryInterface as Query;
use App\Contracts\Repositories\ChatMessageReadRepositoryInterface as Repository;
use App\Contracts\Repositories\LastReadRepositoryInterface as LastReadRepository;
use App\Contracts\Repositories\ChatRoomRepositoryInterface as ChatRoomRepository;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRoom;
use App\Queries\ChatMessageQuery;

class ChatMessageReadService extends Service
{
  use WithRepositoryTrait;

  private $chatMessageQuery;
  private $chatRoomRepository;
  private $lastReadRepository;
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query,
    ChatMessageQuery $chatMessageQuery,
    ChatRoomRepository $chatRoomRepository,
    LastReadRepository $lastReadRepository
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->chatMessageQuery = $chatMessageQuery;
    $this->chatRoomRepository = $chatRoomRepository;
    $this->lastReadRepository = $lastReadRepository;
    // else repository...
  }

  /**
   * @param $chatRoomId
   * @return ChatRoom
   */
  public function store($chatRoomId): ChatRoom
  {
    list($chatRoom, $lastMessageId) = $this->chatRoomRepository->findLastMessageId($chatRoomId);
    $chatMessageIds = $this->chatMessageQuery->unreadIds($chatRoom->id, $lastMessageId);
    if (count($chatMessageIds) > 0) {
      $this->repository()->read(Auth::user()->id, $chatMessageIds);
      $chatRoom = $this->lastReadRepository->saveByRoom($chatRoom, collect($chatMessageIds)->max());
    }
    return $chatRoom;
  }
}

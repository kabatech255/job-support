<?php

namespace App\Services;

use App\Contracts\Queries\ChatMessageQueryInterface as Query;
use App\Contracts\Repositories\ChatMessageRepositoryInterface as Repository;
use App\Contracts\Repositories\ChatMessageImageRepositoryInterface as ChatMessageImageRepository;
use App\Models\ActionType;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\Traits\WithRepositoryTrait;
use App\Services\FileUploadService;
use App\Services\Traits\FileSupportTrait;
use App\Notifications\MessageSentNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\Traits\NotifySupport;

class ChatMessageService extends Service
{
  use WithRepositoryTrait,
    FileSupportTrait;

  private $fileUploadService;
  private $chatMessageImageRepository;
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
    Query $query,
    FileUploadService $fileUploadService,
    ChatMessageImageRepository $chatMessageImageRepository
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->fileUploadService = $fileUploadService;
    $this->chatMessageImageRepository = $chatMessageImageRepository;
  }

  /**
   * @param array $params
   * @param ChatRoom $chatRoom
   * @return ChatMessage
   */
  public function store(array $params, ChatRoom $chatRoom): ChatMessage
  {
    $newMessage = $this->repository()->attach($params, $chatRoom, $this->attachMethod);
    if (isset($params['files'])) {
      $this->uploadImages($params['files'], $newMessage);
    }
    $newMessage->load(ChatMessage::RELATIONS_ARRAY);
    Notification::send($newMessage->chatRoom->members->filter(function ($member) use ($newMessage) {
      return NotifySupport::shouldSend($member, $newMessage->written_by, ActionType::MESSAGE_SENT_KEY);
    }), new MessageSentNotification($newMessage));

    return $newMessage;
  }

  /**
   * @param array $params
   * @param ChatRoom $chatRoom
   * @param $id
   * @return ChatMessage
   */
  public function update(array $params, ChatRoom $chatRoom, $id): ChatMessage
  {
    $updateMessage = $this->repository()->attach($params, $chatRoom, $this->attachMethod, $id);
    if (isset($params['files'])) {
      $this->uploadImages($params['files'], $updateMessage);
    }
    if (isset($params['delete_flags'])) {
      foreach ($params['delete_flags'] as $deleteId) {
        $this->fileUploadService->remove($this->chatMessageImageRepository->findPath($deleteId));
        $this->chatMessageImageRepository->delete($deleteId);
      }
    }
    $updateMessage->load(ChatMessage::RELATIONS_ARRAY);
    return $this->repository()->attach($params, $updateMessage, $this->attachMethod, $id);
  }

  /**
   * @param $id
   * @return ChatMessage
   */
  public function delete($id): ChatMessage
  {
    $chatMessage = $this->repository()->find($id, ChatMessage::RELATIONS_ARRAY);
    $chatMessage->images->each(function ($image) {
      $this->fileUploadService->remove($this->chatMessageImageRepository->findPath($image->id));
      $this->chatMessageImageRepository->delete($image->id);
    });
    $this->repository()->delete($id);
    return $chatMessage;
  }

  private function uploadImages($files, $chatMessage)
  {
    foreach ($files as $image) {
      $params['images'] = $this->fileUpload(['file' => $image], $chatMessage);
      $this->chatMessageImageRepository->attach($params['images'], $chatMessage, 'images');
    }
  }
}

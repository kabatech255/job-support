<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Services\ChatMessageReadService;
use App\Events\MessageRead;
use Illuminate\Support\Facades\Auth;

class ChatMessageReadController extends Controller
{
  private $service;

  public function __construct(ChatMessageReadService $service)
  {
    $this->service = $service;
  }

  /**
   * Store a newly created resource in storage.
   * @param  ChatRoom  $chatRoom
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function store(ChatRoom $chat_room_id, Request $request)
  {
    \DB::beginTransaction();
    try {
      $chatRoom = $this->service->store($chat_room_id);
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      throw $e;
    }
    broadcast(new MessageRead(Auth::user(), $chatRoom->id))->toOthers();
    return response($chatRoom, 201);
  }
}

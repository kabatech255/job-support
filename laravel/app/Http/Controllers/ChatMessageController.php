<?php

namespace App\Http\Controllers;

use App\Events\MessageDelete;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Services\ChatMessageService;
use Illuminate\Http\Request;
use App\Http\Requests\ChatMessage\StoreRequest;
use App\Http\Requests\ChatMessage\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;

class ChatMessageController extends Controller
{
  private $service;

  public function __construct(ChatMessageService $service)
  {
    $this->service = $service;
  }

  /**
   * Store a newly created resource in storage.
   * @param ChatRoom $chat_room_id
   * @param StoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(ChatRoom $chat_room_id, StoreRequest $request)
  {
    DB::beginTransaction();
    try {
      $chatMessage = $this->service->store($request->all(), $chat_room_id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    // event((new MessageSent($chatMessage, Auth::user())));
    broadcast(new MessageSent($chatMessage, 'store'))->toOthers();
    return response($chatMessage, 201);
  }

  /**
   * Update the specified resource in storage.
   * @param UpdateRequest $request
   * @param ChatRoom $chat_room_id
   * @param ChatMessage $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, ChatRoom $chat_room_id, ChatMessage $id)
  {
    DB::beginTransaction();
    try {
      $chatMessage = $this->service->update($request->all(), $chat_room_id, $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    broadcast(new MessageSent($chatMessage, 'update'))->toOthers();
    return response($chatMessage, 200);
  }

  /**
   * Remove the specified resource from storage.
   * @param ChatRoom $chat_room_id
   * @param ChatMessage $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(ChatRoom $chat_room_id, ChatMessage $id)
  {
    $this->authorize('delete', $id);
    \DB::beginTransaction();
    try {
      $result = $this->service->delete($id);
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      throw $e;
    }
    broadcast(new MessageDelete($result))->toOthers();
    return response('', 204);
  }
}

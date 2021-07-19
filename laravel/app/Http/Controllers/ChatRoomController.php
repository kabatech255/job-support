<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRoom\StoreRequest;
use App\Http\Requests\ChatRoom\UpdateRequest;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatRoomService;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
  /**
   * @var ChatRoomService
   */
  protected $service;

  public function __construct(ChatRoomService $service)
  {
    $this->authorizeResource(ChatRoom::class, 'id');
    $this->service = $service;
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function findByOwner()
  {
    return response($this->service->findByOwner());
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * @param StoreRequest $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   * @throws \Throwable
   */
  public function store(StoreRequest $request)
  {
    DB::beginTransaction();
    try {
      $chatRoom = $this->service->store($request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($chatRoom, 201);
  }

  /**
   * @param ChatRoom $id
   * @return \Illuminate\Http\Response
   */
  public function show(ChatRoom $id)
  {
    return response($this->service->find($id), 200);
  }

  /**
   * @param UpdateRequest $request
   * @param ChatRoom $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, ChatRoom $id)
  {
    DB::beginTransaction();
    try {
      $chatRoom = $this->service->update($request->all(), $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($chatRoom, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param ChatRoom $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(ChatRoom $id)
  {
    return response($this->service->delete($id), 204);
  }
}

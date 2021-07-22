<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class UserController extends Controller
{

  private $service;

  public function __construct(UserService $service)
  {
    $this->service = $service;
  }

  public function index()
  {
    return response($this->service->all(), 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param User $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, User $id)
  {
    // return response($request->all());
    \DB::beginTransaction();
    try {
      $user = $this->service->update($request->all(), $id);
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      throw $e;
    }
    return response($user, 200);
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function currentUser()
  {
    $currentUser = $this->service->currentUser();
    return !!$currentUser ? response($currentUser) : response('');
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function withChatRooms()
  {
    $currentUser = $this->service->withChatRooms();
    return !!$currentUser ? response($currentUser) : response('');
  }
}

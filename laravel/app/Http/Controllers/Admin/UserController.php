<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use DB;
use App\Services\UserService as Service;
use App\Models\User;

class UserController extends Controller
{

  private $service;

  public function __construct(Service $service)
  {
    $this->service = $service;
  }

  /**
   * @param Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->index($request->query(), ['createdBy', 'department']), 200);
  }

  /**
   * Undocumented function
   *
   * @param StoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    DB::beginTransaction();
    try {
      $user = $this->service->store($request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
    return response($user, 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  User $id
   * @return \Illuminate\Http\Response
   */
  public function show(User $id)
  {
    return response($this->service->find($id), 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateRequest $request
   * @param  User $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, User $id)
  {
    DB::beginTransaction();
    try {
      $user = $this->service->update($request->all(), $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      throw $e;
    }
    return response($user, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  User $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return response('');
  }
}

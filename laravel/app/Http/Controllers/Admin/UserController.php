<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreRequest;
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
    return response($this->service->index($request->query(), ['createdBy']), 200);
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
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(User $id)
  {
    return response($this->service->find($id), 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    return response('');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return response('');
  }
}

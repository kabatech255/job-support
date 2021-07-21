<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\TaskService as Service;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
  /**
   * @var Service
   */
  private $service;

  public function __construct(Service $service)
  {
    $this->authorizeResource(Task::class, 'id');
    $this->service = $service;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->index($request->query()), 200);
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function findByOwner()
  {
    return response($this->service->findByOwner(Auth::user()->id), 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    DB::beginTransaction();
    try {
      $task = $this->service->store($request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($task, 201);

  }

  /**
   * Display the specified resource.
   *
   * @param Task $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param Task $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, Task $id)
  {
    DB::beginTransaction();
    try {
      $task = $this->service->update($request->all(), $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($task, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Task $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Task $id)
  {
    return response($this->service->delete($id), 204);
  }
}
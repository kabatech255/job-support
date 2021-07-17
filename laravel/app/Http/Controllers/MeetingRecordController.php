<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MeetingRecord\StoreRequest;
use App\Http\Requests\MeetingRecord\UpdateRequest;
use App\Services\MeetingRecordService;
use Illuminate\Support\Facades\DB;

class MeetingRecordController extends Controller
{
  private $perPage = 10;
  private $relation = ['recordedBy', 'place', 'decisions', 'members'];
  private $service;

  public function __construct(MeetingRecordService $service)
  {
    $this->service = $service;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->paginate($request->query(), $this->perPage));
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
      $meetingRecord = $this->service->store($request->all());
      DB::commit();
    } catch(\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($meetingRecord, 201);
  }
  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show(int $id)
  {
    return $this->service->find($id);
  }

  /**
   * @param UpdateRequest $request
   * @param int $id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   * @throws \Throwable
   */
  public function update(UpdateRequest $request, int $id)
  {
    DB::beginTransaction();
    try {
      $meetingRecord = $this->service->update($request->all(), $id);
      DB::commit();
    } catch(\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($meetingRecord, 200);
  }

  /**
   * @param int $id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function destroy(int $id)
  {
    return response($this->service->delete($id), 204);
  }
}

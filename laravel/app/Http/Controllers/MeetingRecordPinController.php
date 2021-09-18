<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingRecordPinService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MeetingRecord;

class MeetingRecordPinController extends Controller
{
  private $perPage = 10;
  private $service;

  public function __construct(MeetingRecordPinService $service)
  {
    $this->service = $service;
  }

  /**
   * @param  MeetingRecord  $id
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function bookmark(MeetingRecord $id, Request $request)
  {
    DB::beginTransaction();
    try {
      $meetingRecord = $this->service->store($id, $request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($meetingRecord, 201);
  }

  /**
   * @param  MeetingRecord  $id
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function unbookmark(MeetingRecord $id, Request $request)
  {
    DB::beginTransaction();
    try {
      $meetingRecord = $this->service->update($id, $request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($meetingRecord, 200);
  }
}

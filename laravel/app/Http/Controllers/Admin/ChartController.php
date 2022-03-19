<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BlogChartService;
use App\Services\ChatChartService;
use App\Services\MeetingRecordChartService;

class ChartController extends Controller
{

  private $blogChartService;
  private $chatChartService;
  private $meetingRecordChartService;

  public function __construct(
    BlogChartService $blogChartService,
    ChatChartService $chatChartService,
    MeetingRecordChartService $meetingRecordChartService
  ) {
    $this->blogChartService = $blogChartService;
    $this->chatChartService = $chatChartService;
    $this->meetingRecordChartService = $meetingRecordChartService;
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function blog(Request $request)
  {
    return response($this->blogChartService->index($request->query()), 200);
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function chat(Request $request)
  {
    return response($this->chatChartService->index($request->query()), 200);
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
   */
  public function meetingRecord(Request $request)
  {
    return response($this->meetingRecordChartService->index($request->query()), 200);
  }
}

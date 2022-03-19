<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MeetingRecordChartService as Service;

class MeetingRecordController extends Controller
{
  private $service;

  public function __construct(Service $service)
  {
    $this->service = $service;
  }

  public function index(Request $request)
  {
    return $this->service->index($request->query());
  }
}

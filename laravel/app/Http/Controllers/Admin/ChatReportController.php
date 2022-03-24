<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\ChatReportService as Service;
use App\Http\Controllers\Controller;

class ChatReportController extends Controller
{
  /**
   * @var Service $service
   */
  private $service;

  public function __construct(Service $service)
  {
    $this->service = $service;
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->index($request->query()), 200);
  }
}

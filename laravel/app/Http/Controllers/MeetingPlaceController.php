<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingPlaceService;

class MeetingPlaceController extends Controller
{
  /**
   * @var ProgressService;
   */
  private $service;

  public function __construct(MeetingPlaceService $service)
  {
    $this->service = $service;
  }

  /**
   * @param Request $request
   * @return void
   */
  public function index(Request $request)
  {
    return response($this->service->all($request->query()), 200);
  }
}

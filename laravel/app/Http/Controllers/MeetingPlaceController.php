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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response($this->service->all(), 200);
  }
}

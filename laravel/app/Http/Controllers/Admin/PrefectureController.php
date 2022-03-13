<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PrefectureService as Service;

class PrefectureController extends Controller
{
  private $service;

  public function __construct(Service $service)
  {
    $this->service = $service;
  }
  /**
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response($this->service->index(), 200);
  }
}

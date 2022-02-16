<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

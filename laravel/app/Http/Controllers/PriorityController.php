<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PriorityService;

class PriorityController extends Controller
{
  /**
   * @var PriorityService;
   */
  private $service;

  public function __construct(PriorityService $service)
  {
    $this->service = $service;
  }
  /**
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return response($this->service->all(), 200);
  }
}

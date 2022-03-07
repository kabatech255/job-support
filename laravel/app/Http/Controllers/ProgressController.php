<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProgressService;

class ProgressController extends Controller
{
  /**
   * @var ProgressService;
   */
  private $service;

  public function __construct(ProgressService $service)
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
    return response($this->service->all($request->query()), 200);
  }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;

class AdminController extends Controller
{
  protected $service;

  public function __construct(AdminService $service)
  {
    $this->service = $service;
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function currentAdmin()
  {
    $currentAdmin = $this->service->currentAdmin();
    return !!$currentAdmin ? response($currentAdmin) : response('');
  }
}

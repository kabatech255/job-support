<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Requests\Admin\StoreRequest;

class AdminController extends Controller
{
  protected $service;

  public function __construct(AdminService $service)
  {
    $this->service = $service;
  }

  /**
   * @param Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->index($request->query(), ['createdBy']), 200);
  }

  /**
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function currentAdmin()
  {
    $currentAdmin = $this->service->currentAdmin();
    return !!$currentAdmin ? response($currentAdmin) : response('');
  }

  /**
   * Undocumented function
   *
   * @param StoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    \DB::beginTransaction();
    try {
      $user = $this->service->store($request->all());
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      throw $e;
    }
    return response($user, 201);
  }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use Illuminate\Http\Request;
use App\Services\DepartmentService as Service;
use App\Models\Department;

class DepartmentController extends Controller
{
  /**
   * @var Service;
   */
  private $service;

  public function __construct(Service $service)
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

  /**
   * @param StoreRequest $request
   * @return void
   */
  public function store(StoreRequest $request)
  {
    \DB::beginTransaction();
    try {
      $model = $this->service->store($request->all());
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollBack();
      throw $e;
    }
    return response($model, 201);
  }

  /**
   * @param UpdateRequest $request
   * @param Department $id
   * @return void
   */
  public function update(UpdateRequest $request, Department $id)
  {
    \DB::beginTransaction();
    try {
      $model = $this->service->update($request->all(), $id);
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollBack();
      throw $e;
    }
    return response($model, 200);
  }

  /**
   * @param Request $request
   * @param Department $id
   * @return void
   */
  public function destroy(Request $request, Department $id)
  {
    return response($this->service->delete($id), 200);
  }
}

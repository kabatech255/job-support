<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Progress\StoreRequest;
use App\Http\Requests\Progress\UpdateRequest;
use App\Services\ProgressService as Service;
use App\Models\Progress;

class ProgressController extends Controller
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
   * @param Progress $id
   * @return void
   */
  public function update(UpdateRequest $request, Progress $id)
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
   * @param Progress $id
   * @return void
   */
  public function destroy(Request $request, Progress $id)
  {
    return response($this->service->delete($id), 200);
  }
}

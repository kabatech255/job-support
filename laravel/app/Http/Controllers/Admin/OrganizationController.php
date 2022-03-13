<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateRequest;
use App\Services\OrganizationService as Service;
use App\Models\Organization;

class OrganizationController extends Controller
{
  private $service;

  public function __construct(Service $service)
  {
    $this->authorizeResource(Organization::class, 'id');
    $this->service = $service;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  UpdateRequest  $request
   * @param  Organization  $id
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   * @throws \Throwable
   */
  public function update(UpdateRequest $request, Organization $id)
  {
    \DB::beginTransaction();
    try {
      $organization = $this->service->update($request->all(), $id);
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      throw $e;
    }
    return response($organization, 200);
  }
}

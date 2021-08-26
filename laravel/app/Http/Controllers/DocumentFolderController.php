<?php

namespace App\Http\Controllers;

use App\Models\DocumentFolder;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentFolder\StoreRequest;
use App\Http\Requests\DocumentFolder\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentFolderService;

class DocumentFolderController extends Controller
{
  /**
   * @var DocumentFolderService
   */
  protected $service;

  public function __construct(DocumentFolderService $service)
  {
    $this->authorizeResource(DocumentFolder::class, 'id');
    $this->service = $service;
  }

  /**
   * @param Request $request
   * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->service->index($request->query()), 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    DB::beginTransaction();
    try {
      $documentFolder = $this->service->store($request->all());
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($documentFolder, 201);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param DocumentFolder $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, DocumentFolder $id)
  {
    DB::beginTransaction();
    try {
      $documentFolder = $this->service->update($request->all(), $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($documentFolder, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param DocumentFolder $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(DocumentFolder $id)
  {
    return response($this->service->delete($id), 204);
  }
}

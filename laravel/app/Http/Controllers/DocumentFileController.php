<?php

namespace App\Http\Controllers;

use App\Models\DocumentFile;
use App\Models\DocumentFolder;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentFile\StoreRequest;
use App\Http\Requests\DocumentFile\UpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentFileService;

class DocumentFileController extends Controller
{
  /**
   * @var DocumentFileService
   */
  protected $service;

  public function __construct(DocumentFileService $service)
  {
    $this->authorizeResource(DocumentFile::class, 'id');
    $this->service = $service;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @param DocumentFolder $folder_id
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request, DocumentFolder $folder_id)
  {
    DB::beginTransaction();
    try {
      $documentFile = $this->service->store($request->all(), $folder_id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($documentFile, 201);
  }

  /**
   * Display the specified resource.
   *
   * @param DocumentFolder $folder_id
   * @param DocumentFile $id
   * @return \Illuminate\Http\Response
   */
  public function show(DocumentFolder $folder_id, DocumentFile $id)
  {
    return response($this->service->find($id), 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param DocumentFolder $folder_id
   * @param DocumentFile $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, DocumentFolder $folder_id, DocumentFile $id)
  {
    DB::beginTransaction();
    try {
      $documentFile = $this->service->update($request->all(), $folder_id, $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($documentFile, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param DocumentFolder $folder_id
   * @param DocumentFile $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(DocumentFolder $folder_id, DocumentFile $id)
  {
    return response($this->service->delete($id), 204);
  }
}

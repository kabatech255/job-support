<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogComment\StoreRequest;
use App\Http\Requests\BlogComment\UpdateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\BlogComment;
use App\Services\BlogCommentService as Service;
use Illuminate\Support\Facades\DB;

class BlogCommentController extends Controller
{
  /**
   * @var Service
   */
  private $service;

  public function __construct(Service $service)
  {
    $this->authorizeResource(BlogComment::class, 'id');
    $this->service = $service;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param StoreRequest $request
   * @param Blog $blog_id
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request, Blog $blog_id)
  {
    DB::beginTransaction();
    try {
      $blogComment = $this->service->store($request->all(), $blog_id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($blogComment, 201);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateRequest $request
   * @param Blog $blog_id
   * @param BlogComment $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, Blog $blog_id, BlogComment $id)
  {
    DB::beginTransaction();
    try {
      $blogComment = $this->service->update($request->all(), $id);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
    return response($blogComment, 200);
  }

  /**
   * @param Blog $blog_id
   * @param BlogComment $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Blog $blog_id, BlogComment $id)
  {
    return response($this->service->delete($id), 204);
  }
}

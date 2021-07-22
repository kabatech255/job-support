<?php

namespace App\Services;

use App\Contracts\Queries\BlogQueryInterface as Query;
use App\Contracts\Repositories\BlogRepositoryInterface as Repository;
use App\Services\Traits\FileSupportTrait;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Services\BlogImageService;

class BlogService extends Service
{
  use WithRepositoryTrait;
  /**
   * @var BlogImageService
   */
  private $blogImageService;
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   * @param FileUploadService $fileUploadService
   */
  public function __construct(
    Repository $repository,
    Query $query,
    BlogImageService $blogImageService
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->blogImageService = $blogImageService;
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @param int|null $perPage
   * @return LengthAwarePaginator
   */
  public function paginate(array $params, ?int $perPage = null, ?array $relation = null): LengthAwarePaginator
  {
    return $this->query()->paginate($params, $perPage, $relation);
  }

  /**
   * @return array
   */
  public function findByOwner(array $loads = [])
  {
    $author = Auth::user();
    if (!!$author) {
      $blogs = $author->blogs;
      $blogs->load($loads);
      return $blogs;
    }
    return [];
  }

  /**
   * @param array $params
   * @return Blog
   */
  public function store(array $params): Blog
  {
    // ブログの保存
    $blog = $this->repository()->saveWithTag($params);
    // 画像のアップロード
    if (isset($params['images'])) {
      $this->blogImageService->saveOrDelete($params['images'], $blog);
    }
    return $blog->load($this->query()->relation());
  }

  /**
   * @param array $params
   * @param $id
   * @return Blog
   */
  public function update(array $params, $id): Blog
  {
    // ブログの保存
    $blog = $this->repository()->saveWithTag($params, $id);
    // 画像のアップロード
    if (isset($params['images'])) {
      $this->blogImageService->saveOrDelete($params['images'], $blog);
    }
    return $blog->load($this->query()->relation());
  }

  /**
   * @param $id
   * @return Blog
   */
  public function like($id): Blog
  {
    $blog = $this->repository()->find($id);
    $blog->likes()->detach(Auth::user()->id);
    $blog->likes()->attach(Auth::user()->id);
    return $blog->load(['likes']);
  }

  /**
   * @param $id
   * @return Blog
   */
  public function unlike($id): Blog
  {
    $blog = $this->repository()->find($id);
    $blog->likes()->detach(Auth::user()->id);
    return $blog->load(['likes']);
  }

  /**
   * @param $id
   * @return Blog
   */
  public function delete($id): Blog
  {
    return $this->repository()->delete($id);
  }
}

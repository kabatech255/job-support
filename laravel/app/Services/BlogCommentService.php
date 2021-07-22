<?php

namespace App\Services;

use App\Contracts\Queries\BlogCommentQueryInterface as Query;
use App\Contracts\Repositories\BlogCommentRepositoryInterface as Repository;
use App\Contracts\Repositories\BlogRepositoryInterface as BlogRepository;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;

class BlogCommentService extends Service
{
  use WithRepositoryTrait;

  private $attachMethod = 'comments';
  /**
   * @var BlogRepository
   */
  private $blogRepository;
  /**
   * UserService constructor.
   * @param Repository $repository
   * @param BlogRepository $blogRepository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    BlogRepository $blogRepository,
    Query $query
  )
  {
    $this->setRepository($repository);
    $this->blogRepository = $blogRepository;
    $this->setQuery($query);
  }

  /**
   * @param array $params
   * @param $blog_id
   * @return BlogComment
   */
  public function store(array $params, $blog_id): BlogComment
  {
    $blog = $this->blogRepository->find($blog_id);
    return $this->repository()->attach($params, $blog, $this->attachMethod)->load($this->query()->relation());
  }
  /**
   * @param array $params
   * @param $id
   * @return BlogComment
   */
  public function update(array $params, $id): BlogComment
  {
    return $this->repository()->save($params, $id)->load($this->query()->relation());
  }

  /**
   * @param $id
   * @return BlogComment
   */
  public function delete($id): BlogComment
  {
    return $this->repository()->delete($id);
  }
}

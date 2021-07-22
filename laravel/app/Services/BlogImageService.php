<?php

namespace App\Services;

use App\Contracts\Queries\BlogImageQueryInterface as Query;
use App\Contracts\Repositories\BlogImageRepositoryInterface as Repository;
use App\Enums\ProcessFlag;
use App\Services\FileUploadService;
use App\Services\Traits\FileSupportTrait;
use App\Services\Traits\WithRepositoryTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\BlogImage;

class BlogImageService extends Service
{
  use WithRepositoryTrait;
  use FileSupportTrait;

  private $attachMethod = 'images';
  /**
   * @var FileUploadService
   */
  private $fileUploadService;

  /**
   * UserService constructor.
   * @param Repository $repository
   * @param Query $query
   */
  public function __construct(
    Repository $repository,
    Query $query,
    FileUploadService $fileUploadService
  )
  {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->fileUploadService = $fileUploadService;
  }

  /**
   * @param array $params
   * @param Blog $blog
   * @return BlogImage
   */
  public function store(array $params, Blog $blog): BlogImage
  {
    $params = $this->fileUpload($params, $blog);
    return $this->repository()->attach($params, $blog, $this->attachMethod);
  }

  /**
   * @param Blog $blog
   * @param array $params
   * @param $id
   * @return BlogImage
   */
  public function update(array $params, Blog $blog, $id): BlogImage
  {
    $params = $this->fileUpload($params, $blog, 'id', $this->repository()->findPath($id));
    return $this->repository()->attach($params, $blog, $this->attachMethod, $id);
  }

  /**
   * @param $id
   * @return BlogImage
   */
  public function delete($id): BlogImage
  {
    $blogImage = $this->repository()->delete($id);
    $this->fileUploadService->remove($blogImage->file_path);
    return $blogImage;
  }

  /**
   * @param $id
   * @return BlogImage
   */
  public function find($id): BlogImage
  {
    return $this->repository()->find($id);
  }

  /**
   * @return BlogImage[]
   */
  public function saveOrDelete(array $params, Blog $blog): array
  {
    foreach($params as $param) {
      if (empty($param['id'] ?? '')) {
        $blogImages[] = $this->store($param, $blog);
      } elseif($param['flag'] === ProcessFlag::value('delete')) {
        $blogImages[] = $this->delete($param['id']);
      } elseif($param['flag'] === ProcessFlag::value('update') && isset($param['file'])) {
        $blogImages[] = $this->update($param, $blog, $param['id']);
      } else {
        $blogImages[] = $this->find($param['id']);
      }
    }
    return $blogImages;
  }

}

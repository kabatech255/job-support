<?php

namespace App\Services;

use App\Contracts\Queries\DocumentFileQueryInterface as Query;
use App\Contracts\Repositories\DocumentFileRepositoryInterface as Repository;
use App\Models\DocumentFile;
use App\Services\Supports\FileSupportTrait;
use App\Services\Supports\WithRepositoryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentFolder;
use App\Contracts\Repositories\DocumentFolderRepositoryInterface as DocumentFolderRepository;
use App\Services\FileUploadService;

class DocumentFileService extends Service
{
  use WithRepositoryTrait,
    FileSupportTrait;

  /**
   * @var DocumentFolderRepository
   */
  private $documentFolderRepository;
  /**
   * @var string
   */
  private $attachMethod = 'files';
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
    DocumentFolderRepository $documentFolderRepository,
    FileUploadService $fileUploadService
  ) {
    $this->setRepository($repository);
    $this->setQuery($query);
    $this->documentFolderRepository = $documentFolderRepository;
    $this->fileUploadService = $fileUploadService;
  }

  /**
   * @param array $params
   * @param $documentFolderId
   * @return DocumentFile
   */
  public function store(array $params, $documentFolderId): DocumentFile
  {
    $documentFolder = $this->documentFolderRepository->find($documentFolderId);
    $params = $this->addMe($params);
    $params = $this->fileUpload($params, $documentFolder, 'random_name');
    return $this->repository()->attachWithMembers($params, $documentFolder);
  }

  /**
   * @param array $params
   * @param $documentFolderId
   * @param $id
   * @return DocumentFile
   */
  public function update(array $params, $documentFolderId, $id): DocumentFile
  {
    return $this->repository()->update($params, $id);
  }

  /**
   * @param $id
   * @return DocumentFile
   */
  public function find($id, ?array $loads = null): DocumentFile
  {
    if (is_null($loads)) {
      $loads = $this->query()->relation();
    }
    return $this->repository()->find($id, $loads);
  }

  /**
   * @param $id
   * @return DocumentFile
   */
  public function delete($id): DocumentFile
  {
    $documentFile = $this->repository()->delete($id);
    $this->fileDelete($documentFile->file_path);
    return $documentFile;
  }

  /**
   * @param string $filePath
   */
  public function fileDelete(string $filePath): void
  {
    $this->fileUploadService->remove($filePath);
  }

  /**
   * @param array $params
   * @return array
   */
  private function addMe(array $params)
  {
    $params['sharedMembers'][Auth::user()->id] = [
      'is_editable' => 1,
      'shared_by' => Auth::user()->id,
    ];
    return $params;
  }
}

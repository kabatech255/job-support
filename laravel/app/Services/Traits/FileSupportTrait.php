<?php

namespace App\Services\Traits;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait FileSupportTrait
{
  /**
   * @var string
   */
  private $baseDir;
  private $fileName;
  private $originalFileName;
  /**
   * @var FileUploadService
   */
  private $fileUploadService;

  public function __construct(FileUploadService $fileUploadService)
  {
    $this->fileUploadService = $fileUploadService;
  }

  private function setFileAttributes($dirName, $file, ?string $fileName = null)
  {
    $this->baseDir = $dirName;
    $this->originalFileName = $file->getClientOriginalName() . '.' . $file->extension();
    $this->fileName = is_null($fileName) ? Str::random(16) : $fileName;
    $this->fileName .= '.' . $file->extension();
  }

  /**
   * @return string
   */
  public function getPath(): string
  {
    return $this->baseDir . '/' . $this->fileName;
  }

  /**
   * @return string
   */
  public function getOriginalFileName(): string
  {
    return $this->originalFileName;
  }

  /**
   * @param Model $model
   * @param string|null $uniqueKey
   * @return string
   */
  private function makeDirName(Model $model, ?string $uniqueKey = null)
  {
    if (is_null($uniqueKey)) {
      $uniqueKey = 'id';
    }
    $baseDirName = Str::singular($model->getTable());
    return "{$baseDirName}/{$model->$uniqueKey}";
  }

  /**
   * @return array
   */
  protected function fileUpload(array $params, Model $model, $uniqueKey = 'id', ?string $oldPath = null): array
  {
    $this->setFileAttributes($this->makeDirName($model, $uniqueKey), $params['file']);
    $params['original_name'] = $this->getOriginalFileName();
    $params['file_path'] = $this->fileUploadService->upload($this->baseDir, $params['file'], $this->fileName);
    if (!is_null($oldPath)) {
      $this->fileUploadService->remove($oldPath);
    }
    return $params;
  }
}

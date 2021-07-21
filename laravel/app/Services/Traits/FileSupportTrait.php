<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait FileSupportTrait
{
  /**
   * @var string
   */
  private $disk;
  private $dirName;
  private $fileName;
  private $originalFileName;

  public function setDisk(string $diskName)
  {
    $this->disk = $diskName;
  }

  public function setAttributes($dirName, $file, ?string $fileName = null)
  {
    $this->dirName = $dirName;
    $this->fileName = is_null($fileName) ? Str::random(16) : $fileName;
    $this->fileName .= '.'.$file->extension();
    $this->originalFileName = $file->getClientOriginalName().'.'.$file->extension();
  }

  public function getPath()
  {
    return $this->dirName . '/' . $this->fileName;
  }

  public function getOriginalFileName()
  {
    return $this->originalFileName;
  }

  /**
   * @param string $parentPath
   * @param Model $model
   * @param string|null $uniqueKey
   * @return string
   */
  private function getDirName(string $parentPath, Model $model, ?string $uniqueKey = null)
  {
    if (is_null($uniqueKey)) {
      $uniqueKey = 'id';
    }
    return "{$parentPath}/{$model->$uniqueKey}";
  }
}

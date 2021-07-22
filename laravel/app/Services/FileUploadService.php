<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadService extends Service
{
  private $disk = 's3';

  /**
   * UserService constructor.
   */
  public function __construct()
  {
  }

  protected function setDisk(string $disk)
  {
    $this->disk = $disk;
  }

  public function disk()
  {
    return $this->disk;
  }

  /**
   * @param string $dirName
   * @param $file
   * @param string $fileName
   * @return false|string
   */
  public function upload(string $dirName, $file, string $fileName)
  {
    return Storage::disk($this->disk())->putFileAs($dirName, $file, $fileName);
  }

  /**
   * @param string $path
   * @return bool
   */
  public function remove(string $path)
  {
    return Storage::disk($this->disk())->delete($path);
  }
}

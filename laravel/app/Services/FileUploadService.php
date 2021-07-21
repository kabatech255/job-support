<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadService extends Service
{

  /**
   * UserService constructor.
   */
  public function __construct()
  {
  }

  /**
   * @param string $dirName
   * @param $file
   * @param string $fileName
   * @return false|string
   */
  public function upload(string $dirName, $file, string $fileName)
  {
    return Storage::disk('public')->putFileAs($dirName, $file, $fileName);
  }

  /**
   * @param string $path
   * @return bool
   */
  public function remove(string $path)
  {
    return Storage::disk('public')->delete($path);
  }
}

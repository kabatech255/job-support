<?php

namespace App\Services\Traits;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait StrSupportTrait
{
  /**
   * @var string
   */
  private $baseDir;
  private $fileName;
  private $originalFileName;

  protected function mbTrim($pString)
  {
    return preg_replace('/( |　)+/', '', $pString);
  }
}

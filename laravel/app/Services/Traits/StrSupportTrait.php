<?php

namespace App\Services\Traits;

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

<?php

namespace App\Services\Supports;

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

  /**
   * @param string $origin
   * @param array $arr
   * @return string
   */
  protected function replaceAttribute(string $origin, array $arr): string
  {
    $replaced = $origin;
    foreach ($arr as $attribute => $value) {
      $match = "/:{$attribute}/";
      $replaced = preg_replace($match, $value, $replaced);
    }
    return $replaced;
  }
}

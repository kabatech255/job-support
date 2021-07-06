<?php

namespace App\Repositories\Abstracts;

abstract class CommonAbstractRepository
{
  /**
   * @param array $params
   * @return array
   */
  protected function qualifiedParams(array $params) : array
  {
    return $params;
  }
  /**
   * @param array $params
   * @return array
   */
  protected function qualifiedStoreParams(array $params) : array
  {
    return $params;
  }

  /**
   * @param array $params
   * @return array
   */
  protected function qualifiedUpdateParams(array $params) : array
  {
    return $params;
  }
}

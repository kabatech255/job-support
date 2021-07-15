<?php

namespace App\Queries\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait BuilderTrait
{
  private $builder;
  private $perPage = 10;
  private $relation = [];
  /**
   * @param Model $model
   * @return $this
   */
  public function setBuilder(Model $model)
  {
    $this->builder = $model;
    return $this;
  }

  /**
   * @return mixed
   */
  public function builder()
  {
    return $this->builder->query();
  }

  /**
   * @return array
   */
  public function relation(): array
  {
    return defined(get_class($this->builder).'::RELATIONS_ARRAY') ? get_class($this->builder)::RELATIONS_ARRAY : $this->relation;
  }

  /**
   * @return int
   */
  public function perPage(): int
  {
    return $this->perPage;
  }

  /**
   * @param string $column
   * @param string $separator
   * @return array|false|string[]
   */
  protected function splitColumn(string $column, string $separator = ':')
  {
    return explode($separator, $column);
  }

  /**
   * @return array
   */
  protected function allColumnNames()
  {
    return Schema::getColumnListing($this->builder->getTable());
  }

  /**
   * @param string $columnName
   * @return bool
   */
  public function isValidColumnName(string $columnName)
  {
    return in_array($columnName, $this->allColumnNames(), true);
  }

  /**
   * @param string $word
   * @return string
   */
  public function liked(string $word)
  {
    return '%' . addcslashes($word, '%_\\') . '%';
  }

}

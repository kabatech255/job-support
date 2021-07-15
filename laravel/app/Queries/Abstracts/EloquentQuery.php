<?php

namespace App\Queries\Abstracts;

use App\Queries\Traits\BuilderTrait;
use Illuminate\Database\Eloquent\Builder;

abstract class EloquentQuery extends CommonAbstractQuery
{
  use BuilderTrait;

  private $targetColumns = [];
  private $relationTargets = [];

  /**
   * @param array $columns
   */
  protected function setColumns(array $columns)
  {
    $this->targetColumns = $columns;
  }
  /**
   * @param array $relationTargets
   */
  protected function setRelationTargets(array $relationTargets)
  {
    $this->relationTargets = $relationTargets;
  }

  /**
   * @return array
   */
  public function columns()
  {
    return $this->targetColumns;
  }

  /**
   * @return array
   */
  public function relationTargets()
  {
    return $this->relationTargets;
  }

  /**
   * @param array $params
   * @param array|null $relation
   * @param int|null $perPage
   * @return mixed
   */
  public function paginate(array $params, ?array $relation = null, ?int $perPage = null)
  {
    return $this->search($params, $relation ?? $this->relation())->paginate($perPage ?? $this->perPage());
  }

  /**
   * @param array $params
   * @param array $relation
   * @return Builder
   */
  public function search(array $params, array $relation = []): Builder
  {
    $query = $this->builder()->with($relation);
    foreach($params as $column => $val) {
      if ($column === 'keyword') {
        $query = $this->searchByKeywords($query, $val);
      } elseif (count($this->splitColumn($column)) >= 2) {
        $query = $this->searchOtherLocation($query, [$column => $val]);
      } elseif ( $this->isValidColumnName($column) ) {
        $query->where($column, 'like', $this->liked($val));
      }
    }
    return $query;
  }

  /**
   * @param Builder $query
   * @param string $keyword
   * @return Builder
   */
  protected function searchByKeywords(Builder $query, string $keyword)
  {
    $likeVal = $this->liked($keyword);
    foreach($this->targetColumns as $columnName) {
      $query->orWhere($columnName, 'like', $likeVal);
    }
    foreach($this->relationTargets as $relation => $relationColumns) {
      foreach($relationColumns as $c) {
        $query->orWhereHas($relation, function($q) use ($likeVal, $c){
          $q->where($c, 'like', $likeVal);
        });
      }
    }
    return $query;
  }

  /**
   * @param Builder $query
   * @param array $param
   */
  protected function searchOtherLocation(Builder $query, array $param)
  {
    $s = key($param);
    $keyword = $param[$s];
    $relationalPair = $this->splitColumn($s);
    $query = $this->otherLocationQuery($query, $relationalPair[0], $relationalPair[1], $keyword, '=');

    return $query;
  }

  /**
   * @param Builder $query
   * @param string $tableName
   * @param string $columnName
   * @param string $value
   * @return Builder
   */
  protected function otherLocationQuery(Builder $query, string $tableName, string $columnName, string $value, string $filter = '=')
  {
    if ($filter === 'like') {
      $value = $this->liked($value);
    }
    $query->whereHas($tableName, function($q) use ($columnName, $value, $filter) {
      if ($this->isValidColumnName($columnName)) {
        $q->where($columnName, $filter, $value);
      }
    });
    return $query;
  }
}

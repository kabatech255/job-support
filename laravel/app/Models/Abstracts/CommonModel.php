<?php

namespace App\Models\Abstracts;

use App\Contracts\Models\RelationalDeleteInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

abstract class CommonModel extends Model
{
  /**
   * @return $this
   */
  public function customDelete()
  {
    $this->fetchDeletedBy();
    $this->save();

    if ($this instanceof RelationalDeleteInterface) {
      foreach($this->getDeleteRelations() as $relation) {
        if ($relation instanceof Collection) {
          $relation->each(function (Model $child) {
            $child->customDelete();
          });
        } elseif ($relation instanceof RelationalDeleteInterface) {
          $relation->customDelete();
        }
      }
    }
    return $this;
  }

  protected function fetchDeletedBy(): void
  {
    if (trait_exists('Illuminate\Database\Eloquent\SoftDeletes')) {
      $this->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
    }
    if (array_key_exists('deleted_by', $this->getAttributes())) {
      $this->deleted_by = Auth::check() ? Auth::user()->id : null;
    }
  }
}

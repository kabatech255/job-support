<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
  protected $table = 'progress';

  protected $fillable = [
    'name',
    'value',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function todos()
  {
    return $this->hasMany(Todo::class, 'progress_id', 'id');
  }
}

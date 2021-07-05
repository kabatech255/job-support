<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
  protected $table = 'priorities';

  protected $fillable = [
    'name',
    'value',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function todos()
  {
    return $this->hasMany(Todo::class, 'priority_id', 'id');
  }
}

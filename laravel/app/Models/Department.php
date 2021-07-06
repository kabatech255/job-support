<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
  use SoftDeletes;

  protected $table = 'departments';
  protected $primaryKey = 'department_code';
  public $incrementing = false;

  protected $fillable = [
    'department_code',
    'name',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function members()
  {
    return $this->hasMany(user::class, 'department_code', 'department_code');
  }

}

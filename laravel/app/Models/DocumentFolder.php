<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFolder extends Model
{
  use SoftDeletes;

  protected $table = 'document_folders';

  protected $fillable = [
    'created_by',
    'role_id',
    'name',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'login_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function files()
  {
    return $this->hasMany(DocumentFile::class, 'folder_id', 'id');
  }
}

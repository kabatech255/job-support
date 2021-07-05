<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFile extends Model
{
  use SoftDeletes;

  protected $table = 'document_files';
  protected $fillable = [
    'uploaded_by',
    'folder_id',
    'file_path',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function uploadedBy()
  {
    return $this->belongsTo(User::class, 'uploaded_by', 'login_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function folder()
  {
    return $this->belongsTo(DocumentFolder::class, 'folder_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedMembers()
  {
    return $this->belongsToMany(User::class, 'document_shares', 'file_id', 'shared_with')
      ->withTimestamps()->withPivot('shared_by');
  }
}

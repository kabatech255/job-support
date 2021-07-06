<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentShare extends Model
{
  protected $table = ['document_shares'];
  protected $fillable = [
    'shared_by',
  ];
  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sharedBy()
  {
    return $this->belongsTo(User::class, 'shared_by', 'id');
  }

}

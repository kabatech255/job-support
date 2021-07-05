<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogImage extends Model
{
  use SoftDeletes;

  protected $table = 'blog_images';

  protected $fillable = [
    'blog_id',
    'file_path',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function blog()
  {
    return $this->belongsTo(Blog::class, 'blog_id', 'id');
  }

}

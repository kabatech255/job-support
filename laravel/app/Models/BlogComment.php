<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
  use SoftDeletes;

  protected $table = 'blog_comments';

  protected $fillable = [
    'written_by',
    'blog_id',
    'body',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function blog()
  {
    return $this->belongsTo(Blog::class, 'blog_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'written_by', 'login_id');
  }
}

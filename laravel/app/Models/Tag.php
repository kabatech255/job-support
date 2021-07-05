<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
  use SoftDeletes;
  protected $table = 'tags';

  protected $fillable = [
    'name',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function blogs()
  {
    return $this->belongsToMany(Blog::class, 'blog_tags', 'tag_id', 'blog_id')->withTimestamps();
  }

}

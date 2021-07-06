<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
  use SoftDeletes;

  protected $table = 'blogs';

  protected $fillable = [
    'written_by',
    'role_id',
    'title',
    'body',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function writtenBy()
  {
    return $this->belongsTo(User::class, 'written_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function tags()
  {
    return $this->belongsToMany(BlogTag::class, 'blog_tags', 'blog_id', 'tag_id')->withTimestamps();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function likes()
  {
    return $this->belongsToMany(User::class, 'likes', 'blog_id', 'liked_by')->withTimestamps();
  }

  /**
   * 楽にコメントを取りに行きたいためbelongsToManyではなくhasMany
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function comments()
  {
    return $this->hasMany(BlogComment::class, 'blog_id', 'id');
  }
  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function images()
  {
    return $this->hasMany(BlogImage::class, 'blog_id', 'id');
  }
}

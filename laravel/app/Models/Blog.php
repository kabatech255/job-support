<?php

namespace App\Models;

use App\Contracts\Models\ModelInterface;
use App\Contracts\Models\RelationalDeleteInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Abstracts\CommonModel as Model;
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property int $written_by 投稿者
 * @property string $title タイトル
 * @property string $body 本文
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogImage[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $writtenBy
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Query\Builder|Blog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereWrittenBy($value)
 * @method static \Illuminate\Database\Query\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Blog withoutTrashed()
 * @mixin \Eloquent
 */
class Blog extends Model implements RelationalDeleteInterface
{
  use SoftDeletes;

  protected $table = 'blogs';

  protected $fillable = [
    'written_by',
    'title',
    'body',
  ];

  const RELATIONS_ARRAY = [
    'comments.writtenBy',
    'tags',
    'images',
    'likes',
    'writtenBy'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function writtenBy()
  {
    return $this->belongsTo(User::class, 'written_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id')->withTimestamps();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function likes()
  {
    return $this->belongsToMany(User::class, 'blog_likes', 'blog_id', 'liked_by')->withTimestamps();
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

  public function getDeleteRelations(): array
  {
    return [
      $this->images,
      $this->comments,
    ];
  }
}

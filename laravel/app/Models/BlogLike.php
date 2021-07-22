<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;

/**
 * App\Models\BlogLike
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $liked_by いいねした人
 * @property int $blog_id ブログID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike whereLikedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLike whereUpdatedAt($value)
 */
class BlogLike extends Model
{
  protected $table = 'blog_likes';
}

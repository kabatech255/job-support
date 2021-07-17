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
 */
class BlogLike extends Model
{
  protected $table = 'likes';
}

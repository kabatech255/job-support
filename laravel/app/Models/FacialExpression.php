<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FacialExpression
 *
 * @property int $id
 * @property string $name 表情名
 * @property string $file_path 画像パス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacialExpression whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FacialExpression extends Model
{
  protected $table = 'facial_expressions';
}

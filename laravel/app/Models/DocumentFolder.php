<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * App\Models\DocumentFolder
 *
 * @property int $id
 * @property int $created_by 作成者
 * @property int $role_id ロールID
 * @property string $name フォルダ名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DocumentFile[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder newQuery()
 * @method static \Illuminate\Database\Query\Builder|DocumentFolder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DocumentFolder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DocumentFolder withoutTrashed()
 * @mixin \Eloquent
 * @property string $random_name ランダムフォルダ名
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFolder whereRandomName($value)
 */
class DocumentFolder extends Model
{
  use SoftDeletes;

  protected $table = 'document_folders';

  protected $fillable = [
    'created_by',
    'role_id',
    'name',
    'random_name',
  ];

  const RELATIONS_ARRAY = [
    'createdBy',
    'role',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (! Arr::get($this->attributes, 'random_name')) {
      $this->setRandomName();
    }
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function files()
  {
    return $this->hasMany(DocumentFile::class, 'folder_id', 'id');
  }

  public function setRandomName()
  {
    $this->attributes['random_name'] = Str::uuid();
  }
}

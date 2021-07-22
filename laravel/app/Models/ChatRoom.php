<?php

namespace App\Models;

use App\Contracts\Models\RelationalDeleteInterface;
use App\Models\Abstracts\CommonModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\ChatRoom
 *
 * @property int $id
 * @property int $created_by 作成者
 * @property string|null $name ルーム名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatMessage[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @property-read int|null $shared_members_count
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRoom whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Query\Builder|ChatRoom onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|ChatRoom withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ChatRoom withoutTrashed()
 */
class ChatRoom extends Model implements RelationalDeleteInterface
{
  use SoftDeletes;

  protected $table = 'chat_rooms';
  protected $fillable = [
    'created_by',
    'name',
  ];

  protected $appends = [
    'can_edit',
  ];

  const RELATIONS_ARRAY = [
    'members',
    'messages.writtenBy',
    'messages.to',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function members()
  {
    return $this->belongsToMany(User::class, 'chat_room_shares', 'chat_room_id', 'shared_with')
      ->as('option')->withTimestamps()->withPivot('shared_by', 'is_editable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function messages()
  {
    return $this->hasMany(ChatMessage::class, 'chat_room_id', 'id');
  }

  /**
   * @return bool
   */
  public function getCanEditAttribute(): bool
  {
    if (!Auth::check()) {
      return false;
    }
    return $this->members->contains(function ($member) {
      return $member->id === Auth::user()->id && $member->option->is_editable;
    });
  }

  public function getDeleteRelations(): array
  {
    return [
      $this->messages
    ];
  }
}

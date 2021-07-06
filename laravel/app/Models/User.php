<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
  use SoftDeletes;
  use Notifiable;

  protected $table = 'users';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'last_name',
    'first_name',
    'last_name_kana',
    'first_name_kana',
    'file_name',
    'email',
    'user_code',
    'role_id',
    'login_id',
    'password',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function ownTodos()
  {
    return $this->hasMany(Todo::class, 'login_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function department()
  {
    return $this->belongsTo(Department::class, 'department_code', 'department_code');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function chatRooms()
  {
    return $this->belongsToMany(ChatRoom::class, 'chat_room_shares', 'shared_with', 'chat_room_id')
      ->withTimestamps()->withPivot('shared_by');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedDocuments()
  {
    return $this->belongsToMany(User::class, 'document_shares', 'shared_with', 'file_id')
      ->withTimestamps()->withPivot('shared_by');
  }

  /**
   * 参加したミーティング
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function meetings()
  {
    return $this->belongsToMany(MeetingRecord::class, 'meeting_members', 'member_id', 'meeting_record_id')->withTimestamps();
  }

  /**
   * 共有されたスケジュール
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedSchedules()
  {
    return $this->belongsToMany(User::class, 'schedule_shares', 'shared_with', 'schedule_id')
      ->withTimestamps()
      ->withPivot('is_editable', 'shared_by');
  }

}

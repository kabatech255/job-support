<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\MailResetPasswordNotification;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $department_code 部署ID
 * @property int $user_code ユーザーコード
 * @property int $role_id ロールID
 * @property string $login_id ログインID
 * @property string $family_name 姓
 * @property string $given_name 名
 * @property string|null $family_name_kana セイ
 * @property string|null $given_name_kana メイ
 * @property string|null $file_path 画像
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $created_by 登録者
 * @property string|null $updated_by 更新者
 * @property string|null $deleted_by 削除者
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatRoom[] $chatRooms
 * @property-read int|null $chat_rooms_count
 * @property-read \App\Models\Department|null $department
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MeetingRecord[] $meetings
 * @property-read int|null $meetings_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $ownTasks
 * @property-read int|null $own_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $sharedDocuments
 * @property-read int|null $shared_documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $sharedSchedules
 * @property-read int|null $shared_schedules_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCode($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFilePath($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFamilyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFamilyNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGivenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGivenNameKana($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Blog[] $blogs
 * @property-read int|null $blogs_count
 * @property-read \App\Models\Role $role
 */
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
    'family_name',
    'given_name',
    'family_name_kana',
    'given_name_kana',
    'file_path',
    'email',
    'user_code',
    'role_id',
    'login_id',
    'password',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  protected $appends = [
    'full_name',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'email_verified_at',
    'login_id',
    'role_id',
    'deleted_at',
    'created_by',
    'updated_by',
    'deleted_by',
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
   * @return string
   */
  public function getFullNameAttribute()
  {
    return $this->family_name . ' ' . $this->given_name;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function blogs()
  {
    return $this->hasMany(Blog::class, 'written_by', 'id');
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
      ->withTimestamps()->withPivot('shared_by', 'is_editable');
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
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function chatMessageReads()
  {
    return $this->belongsToMany(ChatMessage::class, 'chat_message_reads', 'member_id', 'chat_message_id')->withTimestamps();
  }

  /**
   * 共有されたスケジュール
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function sharedSchedules()
  {
    return $this->belongsToMany(Schedule::class, 'schedule_shares', 'shared_with', 'schedule_id')
      ->withTimestamps()
      ->withPivot('is_editable', 'shared_by');
  }

  /**
   * 通知アクティビティ
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function activities()
  {
    return $this->belongsToMany(ActionType::class, 'activities', 'user_id', 'action_type_id')
      ->as('option')
      ->withTimestamps()
      ->withPivot('is_read');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function notifyValidations()
  {
    return $this->hasMany(NotifyValidation::class, 'user_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function tasks()
  {
    return $this->hasMany(Task::class, 'owner_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  /**
   * パスワードリセット通知の送信
   *
   * @param  string  $token
   * @return void
   */
  public function sendPasswordResetNotification($token)
  {
    $this->notify(new MailResetPasswordNotification($token));
  }
}

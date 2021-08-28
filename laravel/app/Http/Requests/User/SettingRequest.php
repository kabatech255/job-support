<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
  const MULTIPLE_NUM = 5;
  const MAX_FILE_SIZE = 1024 * self::MULTIPLE_NUM; // 5M

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // return $this->user()->can('update', $this->route('id'));
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'notify_validations' => [
        'array',
      ],
      'notify_validations.*' => [
        'boolean',
      ],
      'change_password' => [
        'nullable',
        'boolean',
      ],
      'current_password' => [
        'required_if:change_password, 1',
        'password:api',
      ],
      'password' => [
        'required_if:change_password, 1',
        'string',
        'min:8',
        'max:64',
        'regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[=\w\-\?]+\z/',
        'confirmed',
      ],
    ];
  }

  public function attributes()
  {
    return [
      'message_sent' => 'メッセージが送信されたときの通知フラグ',
      'meeting_record_joined' => '議事録追加の通知フラグ',
      'schedule_shared' => 'スケジュールが共有されたときの通知フラグ',
      'change_password' => 'パスワードの変更',
      'current_password' => '現在のパスワード',
      'password' => '新しいパスワード',
    ];
  }

  public function messages()
  {
    return  [
      'current_password.password' => ':attributeが一致しませんでした',
      'current_password.required_if' => ':attributeを指定して下さい',
      'password.required_if' => ':attributeを指定して下さい',
    ];
  }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
      'family_name' => [
        'nullable',
        'string',
        'max:20',
      ],
      'given_name' => [
        'nullable',
        'string',
        'max:20',
      ],
      'family_name_kana' => [
        'nullable',
        'string',
        'regex:/\A[ァ-ヴーｦ-ﾟ]+\z/u',
        'max:20',
      ],
      'given_name_kana' => [
        'nullable',
        'string',
        'regex:/\A[ァ-ヴーｦ-ﾟ]+\z/u',
        'max:20',
      ],
      'delete_flag' => [
        'nullable',
        'boolean',
      ],
      'file' => [
        'nullable',
        'mimes:jpg,jpeg,png,gif,svg',
        'max:' . self::MAX_FILE_SIZE
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
      'family_name' => '姓',
      'family_name_kana' => 'セイ',
      'given_name' => '名',
      'given_name_kana' => 'メイ',
      'change_password' => 'パスワードの変更',
      'delete_flag' => '画像の削除フラグ',
      'file' => '画像ファイル',
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
      'file.mimes' => ':attributeの形式が正しくありませんでした',
    ];
  }
}

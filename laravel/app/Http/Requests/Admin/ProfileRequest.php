<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        'katakana',
        'max:20',
      ],
      'given_name_kana' => [
        'nullable',
        'string',
        'katakana',
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
    ];
  }

  public function attributes()
  {
    return [
      'family_name' => '姓',
      'family_name_kana' => 'セイ',
      'given_name' => '名',
      'given_name_kana' => 'メイ',
      'delete_flag' => '画像の削除フラグ',
      'file' => '画像ファイル',
    ];
  }

  public function messages()
  {
    return  [
      'file.mimes' => ':attributeの形式が正しくありません',
    ];
  }
}

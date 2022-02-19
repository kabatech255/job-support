<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * @return array
   */
  public function rules()
  {
    return [
      'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
      'family_name' => ['required', 'string', 'max:128'],
      'family_name_kana' => ['required', 'katakana', 'max:128'],
      'given_name' => ['required', 'string', 'max:128'],
      'given_name_kana' => ['required', 'katakana', 'max:128'],
    ];
  }
}

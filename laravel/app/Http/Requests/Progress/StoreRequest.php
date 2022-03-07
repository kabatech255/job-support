<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

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
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|string|max:64',
      'value' => 'required|integer|max:9999999',
    ];
  }

  public function attributes()
  {
    return [
      'name' => '進捗度',
      'value' => '優先値',
    ];
  }
}

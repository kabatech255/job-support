<?php

namespace App\Http\Requests\Department;

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
      'name' => 'required|string|max:128',
      'department_code' => 'nullable|max:64|regex:/^[a-zA-Z0-9-_]+$/',
      'color' => 'nullable|string|max:64'
    ];
  }

  public function attributes()
  {
    return [
      'name' => '部署名',
      'department_code' => '部署コード',
      'color' => '色',
    ];
  }
}

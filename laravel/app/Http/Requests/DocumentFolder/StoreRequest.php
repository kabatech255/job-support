<?php

namespace App\Http\Requests\DocumentFolder;

use App\Models\Role;
use App\Models\User;
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
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'created_by' => 'required|integer|'.Rule::in(User::pluck('id')->toArray()),
      'name' => 'required|string|max:80',
      'role_id' => 'nullable|integer|'.Rule::in(Role::pluck('id')->toArray()),
    ];
  }

  public function attributes()
  {
    return [
      'created_by' => '作成者のID',
      'name' => 'フォルダ名',
      'role_id' => '権限ID',
    ];
  }
}

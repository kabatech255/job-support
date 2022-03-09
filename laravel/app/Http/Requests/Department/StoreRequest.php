<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
      'name' => ['required', 'string', 'max:128', Rule::notIn($this->departmentNameArr())],
      'department_code' => ['nullable', 'max:64', 'regex:/^[a-zA-Z0-9-_]+$/', Rule::notIn($this->departmentCodeArr())],
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

  public function messages()
  {
    return array_merge(parent::messages(), [
      'department_code.not_in' => 'その:attributeは既に使われています',
      'name.not_in' => 'その:attributeは既に使われています',
    ]);
  }

  protected function departmentCodeArr()
  {
    return Department::where('department_code', $this['department_code'])->get()->filter(function ($department) {
      return $department->createdBy->organization_id === Auth::user()->organization_id;
    })->pluck('department_code')->toArray();
  }

  protected function departmentNameArr()
  {
    return Department::where('name', $this['name'])->get()->filter(function ($department) {
      return $department->createdBy->organization_id === Auth::user()->organization_id;
    })->pluck('name')->toArray();
  }
}

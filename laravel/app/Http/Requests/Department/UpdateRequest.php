<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends StoreRequest
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
    return parent::rules();
  }

  protected function departmentCodeArr()
  {
    $codes = parent::departmentCodeArr();
    return \Arr::where($codes, function ($value) {
      $me = $this->route('id');
      return $value !== $me->department_code;
    });
  }

  protected function departmentNameArr()
  {
    return \Arr::where(parent::departmentNameArr(), function ($value) {
      $me = $this->route('id');
      return $value !== $me->name;
    });
  }
}

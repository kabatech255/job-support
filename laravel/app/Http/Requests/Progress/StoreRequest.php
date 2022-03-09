<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Progress;
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
      'name' => [
        'required',
        'string',
        'max:64',
        Rule::notIn($this->nameArr()),
      ],
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

  public function messages()
  {
    return array_merge(parent::messages(), [
      'name.not_in' => 'その:attributeは既に使われています',
    ]);
  }

  protected function nameArr()
  {
    return Progress::where('name', $this['name'])->get()->filter(function ($progress) {
      return $progress->createdBy->organization_id === Auth::user()->organization_id;
    })->pluck('name')->toArray();
  }
}

<?php

namespace App\Http\Requests\MeetingPlace;

use App\Models\MeetingPlace;
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
      'name' => [
        'required',
        'string',
        'max:64',
        Rule::notIn($this->nameArr()),
      ],
    ];
  }

  public function attributes()
  {
    return [
      'name' => '会議室名'
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
    return MeetingPlace::where('name', $this['name'])->get()->filter(function ($progress) {
      return $progress->createdBy->organization_id === Auth::user()->organization_id;
    })->pluck('name')->toArray();
  }
}

<?php

namespace App\Http\Requests\MeetingPlace;

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

  protected function nameArr()
  {
    $names = parent::nameArr();
    return \Arr::where($names, function ($value) {
      $me = $this->route('id');
      return $value !== $me->name;
    });
  }
}

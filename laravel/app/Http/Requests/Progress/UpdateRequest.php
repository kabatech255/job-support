<?php

namespace App\Http\Requests\Progress;

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

  protected function nameArr()
  {
    $names = parent::nameArr();
    return \Arr::where($names, function ($value) {
      $me = $this->route('id');
      return $value !== $me->name;
    });
  }
}

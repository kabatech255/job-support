<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends StoreRequest
{
  /**
   * @return bool
   */
  public function authorize()
  {
    return $this->user()->can('update', $this->route('id'));
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

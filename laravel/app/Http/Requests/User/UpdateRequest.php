<?php

namespace App\Http\Requests\User;

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
    $u = $this->route('id');
    if ($u) {
      $id = $u->id;
    }
    return array_merge(parent::rules(), [
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        'unique:users,email,' . $id . ',id',
      ]
    ]);
  }
}

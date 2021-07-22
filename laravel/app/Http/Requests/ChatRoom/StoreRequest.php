<?php

namespace App\Http\Requests\ChatRoom;

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
      'name' => 'nullable|string|max:50',
      'created_by' => 'nullable|integer|' . Rule::in(User::pluck('id')->toArray()),
      'members' => 'nullable|array',
      'members.*' => 'nullable|array',
      'members.*.is_editable' => 'required|boolean',
      'members.*.shared_by' => 'required|integer|' . Rule::in(User::pluck('id')->toArray()),
    ];
  }
}

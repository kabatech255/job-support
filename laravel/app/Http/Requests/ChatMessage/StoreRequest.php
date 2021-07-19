<?php

namespace App\Http\Requests\ChatMessage;

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
    return $this->user()->can('storeMessage', $this->route('chat_room_id'));
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'written_by' => 'required|integer|'.Rule::in(User::pluck('id')->toArray()),
      'mentioned_to' => 'nullable|integer|'.Rule::in(User::pluck('id')->toArray()),
      'body' => 'required|string',
    ];
  }
}

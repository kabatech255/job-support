<?php

namespace App\Http\Requests\MeetingRecord;

use App\Models\MeetingDecision;
use App\Models\Todo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProcessFlag;

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
    return array_merge([
      'meeting_decisions.*.id' => 'nullable|integer|' . Rule::in(MeetingDecision::pluck('id')->toArray()),
      'meeting_decisions.*.todos.*.id' => 'nullable|integer|' . Rule::in(Todo::pluck('id')->toArray()),
      'meeting_decisions.*.flag' => 'nullable|integer|' . Rule::in(MeetingDecision::pluck('id')->toArray()),
      'meeting_decisions.*.todos.*.flag' => 'nullable|integer|' . Rule::in(ProcessFlag::values()),
    ],parent::rules());
  }
}

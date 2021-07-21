<?php

namespace App\Http\Requests\MeetingRecord;

use App\Models\MeetingDecision;
use App\Models\Task;
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
    return $this->user()->can('update', $this->route('id'));
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
      'meeting_decisions.*.tasks.*.id' => 'nullable|integer|' . Rule::in(Task::pluck('id')->toArray()),
      'meeting_decisions.*.flag' => 'nullable|integer|' . Rule::in(ProcessFlag::values()),
      'meeting_decisions.*.tasks.*.flag' => 'nullable|integer|' . Rule::in(ProcessFlag::values()),
    ],parent::rules());
  }
}

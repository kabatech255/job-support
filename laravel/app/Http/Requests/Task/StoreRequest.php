<?php

namespace App\Http\Requests\Task;

use App\Models\Priority;
use App\Models\Progress;
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
      'created_by' => 'nullable|integer|'. Rule::in(User::pluck('id')->toArray()),
      'owner_id' => 'required|integer|'. Rule::in(User::pluck('id')->toArray()),
      'priority_id' => 'nullable|integer|'. Rule::in(Priority::pluck('id')->toArray()),
      'progress_id' => 'nullable|integer|'. Rule::in(Progress::pluck('id')->toArray()),
      'body' => 'required|string|max:80',
      'time_limit' => 'required|date_format:Y/m/d H:i',
    ];
  }

  public function attributes()
  {
    return [
      'created_by' => '作成者のID',
      'owner_id' => '所有者ID',
      'priority_id' => '優先度',
      'progress_id' => '進捗度',
      'body' => 'タスクの内容',
      'time_limit' => '期日',
    ];
  }
}

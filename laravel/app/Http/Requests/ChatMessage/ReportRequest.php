<?php

namespace App\Http\Requests\ChatMessage;

use App\Models\ReportCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    $chatMessage = $this->route('id');
    return $this->user()->can('report', $chatMessage->chatRoom);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'report_category_id' => Rule::in(ReportCategory::pluck('id')->toArray())
    ];
  }
}

<?php

namespace App\Http\Requests\Blog;

use App\Enums\ProcessFlag;
use App\Models\BlogImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

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
      'images' => 'nullable|array',
      'images.*.id' => 'nullable|integer|'.Rule::in(BlogImage::pluck('id')->toArray()),
      'images.*.file_path' => 'nullable|string',
      'images.*.flag' => 'nullable|integer|'.Rule::in(ProcessFlag::values()),
    ], parent::rules());
  }

  public function attributes()
  {
    return parent::attributes();
  }

  public function messages()
  {
    return parent::messages();
  }
}

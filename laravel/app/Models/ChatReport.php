<?php

namespace App\Models;

use App\Models\Abstracts\CommonModel as Model;
use App\Models\ReportCategory;

class ChatReport extends Model
{
  protected $fillable = [
    'report_category_id'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function reportCategory()
  {
    return $this->belongsTo(ReportCategory::class, 'report_category_id', 'id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function chatMessage()
  {
    return $this->belongsTo(ChatMessage::class, 'chat_message_id', 'id');
  }
}

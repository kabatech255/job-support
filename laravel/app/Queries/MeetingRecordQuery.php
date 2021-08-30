<?php

namespace App\Queries;

use App\Contracts\Queries\MeetingRecordQueryInterface;
use App\Queries\Abstracts\EloquentQuery;
use App\Models\MeetingRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MeetingRecordQuery extends EloquentQuery implements MeetingRecordQueryInterface
{
  public function __construct(MeetingRecord $model)
  {
    $this->setBuilder($model);
    $this->setColumns(['title', 'summary', 'recorded_by', 'meeting_date']);
    $this->setRelationTargets([
      'place' => [
        'name',
      ],
      'recordedBy' => [
        'user_code',
        'given_name',
        'family_name',
        'given_name_kana',
        'family_name_kana',
      ],
      'members' => [
        'id',
        'given_name',
        'family_name',
        'given_name_kana',
        'family_name_kana',
      ],
      'decisions' => [
        'subject',
        'body',
      ],
    ]);
  }

  public function search(array $params, array $relation = []): Builder
  {
    $query = parent::search($params, $relation);
    if (!empty($params['only_me'] ?? '') && Auth::check()) {
      $query = $query->whereHas('members', function ($q) {
        $q->where('member_id', Auth::user()->id);
      });
    }
    if (isset($params['count'])) {
      $query = $this->queryByMemberCount($query, $params['count']);
    }
    if (isset($params['meeting_date'])) {
      $query = $this->queryByMeetingDate($query, $params['meeting_date']);
    }
    return $query;
  }

  /**
   * @param Builder $query
   * @param string $param
   * @return Builder
   */
  public function queryByMeetingDate($query, string $date): Builder
  {
    $query->where('meeting_date', 'like', $this->liked($date));
    return $query;
  }

  /**
   * @param Builder $query
   * @param array $param
   * @return Builder
   */
  public function queryByMemberCount($query, array $param): Builder
  {
    $min = $param['min'] ?? 0;
    $query->has('members', '>=', $min);
    if (isset($param['max'])) {
      $query->has('members', '<=', $param['max']);
    }
    return $query;
  }

  public function oldestMeetingDate()
  {
    return $this->builder()->orderBy('meeting_date')->first()->meeting_date;
  }
}

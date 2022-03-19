<?php

namespace App\Services;

use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Carbon;

class ChartService extends Service
{
  use RepositoryUsingSupport;

  protected $tableName = 'meeting_records';

  public function index(array $params)
  {
    if (!isset($params['group'])) {
      $params['group'] = 'monthly';
    }
    return $this->countsPerYearMonth($params);
  }

  protected function countsPerYearMonth(array $params)
  {
    $oldestDate = Carbon::parse('-1 year')->format('Y-m-d');
    $groupKey = $this->getGroupKey($params['group']);
    $records = \DB::table($this->tableName)
      ->join('users', $this->tableName . '.created_by', '=', 'users.id')
      ->where('users.organization_id', $params['createdBy:organization_id'])
      ->whereDate($this->tableName . '.created_at', '>', $oldestDate)
      ->groupBy(\DB::raw("{$groupKey}"))
      ->select(\DB::raw("{$groupKey} as keyName, COUNT(*) as C"))
      ->pluck('C', 'keyName');

    return [
      'labels' => $records->keys()->all(),
      'data' => [
        'minutes' => $records->values()->all()
      ],
    ];
  }

  protected function getGroupKey($groupName = 'monthly')
  {
    $groupKeys = [
      'monthly' => "DATE_FORMAT({$this->tableName}.created_at, '%y-%m')",
      'user' => "{$this->tableName}.created_by"
    ];

    return $groupKeys[$groupName];
  }
}

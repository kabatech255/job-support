<?php

namespace App\Services;

use App\Services\Supports\RepositoryUsingSupport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;

class ChartService extends Service
{
  use RepositoryUsingSupport;
  const MONTHS = 11;

  protected $tableName = 'meeting_records';
  protected $relatedTableName = 'users';
  protected $dataKey = 'minutes';

  /**
   * @var UserRepository $userRepository
   */
  protected $userRepository;

  /**
   * @param UserRepository $userRepository
   */
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function index(array $params)
  {
    if (!isset($params['group'])) {
      $params['group'] = 'monthly';
    }
    return $this->countsPerYearMonth($params);
  }

  protected function countsPerYearMonth(array $params)
  {
    $records = $this->getChartQuery($params);

    return [
      'labels' => $this->getChartLabels($records->keys()->all(), $params['group']),
      'data' => [
        $this->dataKey => $this->getChartValues($records, $params['group'])
      ],
    ];
  }

  protected function getChartQuery(array $params)
  {
    $oldestDate = $this->oldestDate()->format('Y-m-d');
    $groupKey = $this->getGroupKey($params['group']);

    $query = \DB::table($this->tableName)
      ->join('users', $this->tableName . '.created_by', '=', 'users.id')
      ->where('users.organization_id', $params['createdBy:organization_id'])
      ->whereDate($this->tableName . '.created_at', '>', $oldestDate);

    if (isset($params['created_by_table'])) {
      $query = $query->where("{$params['created_by_table']}.created_by", $params['created_by']);
    }

    return $query->groupBy(\DB::raw("{$groupKey}"))
      ->select(\DB::raw("{$groupKey} as keyName, COUNT(*) as C"))
      ->pluck('C', 'keyName');
  }

  protected function oldestDate()
  {
    return Carbon::now()->firstOfMonth()->subMonths(self::MONTHS);
  }

  protected function getGroupKey($groupName = 'monthly')
  {
    $groupKeys = $this->groupKeys();
    return $groupKeys[$groupName];
  }

  protected function groupKeys()
  {
    return [
      'monthly' => "DATE_FORMAT({$this->tableName}.created_at, '%y-%m')",
      'user' => "{$this->tableName}.created_by"
    ];
  }

  protected function getChartLabels(array $recordKeys, $groupName)
  {
    if ($groupName === 'user') {
      return collect($recordKeys)->map(function ($id) {
        $user = $this->userRepository->find($id);
        return $user->full_name;
      })->all();
    } elseif ($groupName === 'monthly') {
      return $this->defaultChartLabels();
    } else {
      return $recordKeys;
    }
  }

  protected function getChartValues(Collection $records, $groupName)
  {
    if ($groupName === 'monthly') {
      $labels = $this->defaultChartLabels();
      $values = [];
      foreach ($labels as $label) {
        $values[] = $records->get($label, 0);
      }
      return $values;
    } else {
      return $records->values()->all();
    }
  }

  protected function defaultChartLabels()
  {
    $currentMonth = Carbon::now()->firstOfMonth();
    $labels = [$currentMonth->format('y-m')];
    for ($i = 0; $i < self::MONTHS; $i++) {
      $currentMonth->subMonth();
      $labels[] = $currentMonth->format('y-m');
    }
    return array_reverse($labels);
  }
}

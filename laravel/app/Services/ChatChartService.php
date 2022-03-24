<?php

namespace App\Services;

use App\Contracts\Repositories\ChatMessageRepositoryInterface as ChatMessageRepository;
use App\Contracts\Repositories\UserRepositoryInterface as UserRepository;

class ChatChartService extends ChartService
{
  protected $tableName = 'chat_reports';
  protected $dataKey = 'report';
  protected $relatedTableName = 'chat_messages';

  /**
   * @var ChatMessageRepository $chatMessageRepository
   */
  protected $chatMessageRepository;

  /**
   * @param ChatMessageRepository $chatMessageRepository
   */
  public function __construct(UserRepository $userRepository, ChatMessageRepository $chatMessageRepository)
  {
    parent::__construct($userRepository);
    $this->chatMessageRepository = $chatMessageRepository;
  }

  protected function countsPerYearMonth(array $params)
  {
    if ($params['group'] === 'monthly') {
      $records = parent::getChartQuery($params);
    } else {
      $records = $this->getChartQuery($params);
    }
    return [
      'labels' => $this->getChartLabels($records->keys()->all(), $params['group']),
      'data' => [
        $this->dataKey => $this->getChartValues($records, $params['group'])
      ],
    ];
  }

  protected function getChartQuery(array $params)
  {
    $oldestDate = $this->oldestDate();
    $groupKey = $this->getGroupKey($params['group']);

    $query = \DB::table($this->tableName)
      ->join('users', $this->tableName . '.created_by', '=', 'users.id')
      ->join($this->relatedTableName, "{$this->tableName}.chat_message_id", '=', "{$this->relatedTableName}.id")
      ->where("{$this->tableName}.report_category_id", '>', 0)
      ->where('users.organization_id', $params['createdBy:organization_id'])
      ->whereDate("{$this->tableName}.created_at", '>', $oldestDate);

    if (isset($params['created_by_table'])) {
      $query = $query->where("{$params['created_by_table']}.created_by", $params['created_by']);
    }
    return $query->groupBy(\DB::raw("{$groupKey}"))
      ->select(\DB::raw("{$groupKey} as keyName, COUNT(*) as C"))
      ->pluck('C', 'keyName');
  }

  protected function groupKeys()
  {
    return [
      'monthly' => "DATE_FORMAT({$this->tableName}.created_at, '%y-%m')",
      'user' => "{$this->relatedTableName}.created_by",
      'post' => "{$this->relatedTableName}.id"
    ];
  }

  protected function getChartLabels(array $recordKeys, $groupName)
  {
    if ($groupName === 'post') {
      return collect($recordKeys)->map(function ($id) {
        $chatMessage = $this->chatMessageRepository->find($id);
        return \Str::limit($chatMessage->body, 20, '...');
      })->all();
    }
    return parent::getChartLabels($recordKeys, $groupName);
  }
}

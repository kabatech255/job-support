<?php
namespace App\Contracts\Queries;

interface MeetingRecordQueryInterface extends QueryInterface
{
  public function queryByMemberCount($query, array $params);
}

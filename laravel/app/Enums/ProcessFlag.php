<?php

namespace App\Enums;

class ProcessFlag
{
  const KEY_UPDATE = 'update';
  const KEY_DELETE = 'delete';
  const KEY_NOTHING = 'nothing';
  const PROCESS_FLAG_ARRAY = [
    self::KEY_UPDATE => 1,
    self::KEY_DELETE => 2,
    self::KEY_NOTHING => 3,
  ];

  public static function values()
  {
    return array_values(self::PROCESS_FLAG_ARRAY);
  }

  public static function keys()
  {
    return array_keys(self::PROCESS_FLAG_ARRAY);
  }

  public static function value(string $key)
  {
    return self::PROCESS_FLAG_ARRAY[$key];
  }


}

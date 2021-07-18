<?php

namespace App\Enums;

class Role
{
  const KEY_ADMIN = 'administrator';
  const KEY_MANAGER = 'manager';
  const KEY_LEADER = 'leader';
  const KEY_STAFF = 'staff';

  const ROLE_ARRAY = [
    self::KEY_ADMIN => 255,
    self::KEY_MANAGER => 100,
    self::KEY_LEADER => 99,
    self::KEY_STAFF => 98,
  ];

  const ROLE_LABEL_ARRAY = [
    self::KEY_ADMIN => 'システム管理者',
    self::KEY_MANAGER => 'マネージャー',
    self::KEY_LEADER => 'リーダー',
    self::KEY_STAFF => '一般',
  ];

  public static function values()
  {
    return array_values(self::ROLE_ARRAY);
  }

  public static function keys()
  {
    return array_keys(self::ROLE_ARRAY);
  }

  public static function value(string $key)
  {
    return self::ROLE_ARRAY[$key];
  }


}

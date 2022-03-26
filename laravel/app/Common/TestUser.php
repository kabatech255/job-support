<?php

namespace App\Common;

class TestUser
{
  public static function hasId()
  {
    return !!config('app.test_id');
  }

  public static function user()
  {
    return \DB::table('users')->where('login_id', config('app.test_id'))->first();
  }

  public static function id()
  {
    $user = self::user();
    if (!!$user) {
      return $user->id;
    } else {
      return null;
    }
  }
}

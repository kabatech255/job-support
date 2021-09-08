<?php

namespace App\Common;

class TestUser
{
  public static function hasId()
  {
    return !!config('app.test_id');
  }
}

<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Admin;
use Faker\Factory;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  /**
   * @var Admin
   */
  protected $admin;

  protected function setUp(): void
  {
    parent::setUp();
    $this->admin = Admin::where('email', $this->user->email)->first();
  }
}

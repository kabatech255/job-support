<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Admin\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
  use WithFaker;

  /**
   * @test
   * @group admin_user
   */
  public function should_一般ユーザの追加()
  {
    $beforeCount = User::count();
    $expects = [
      'family_name' => $this->faker->lastName,
      'family_name_kana' => $this->faker->lastKanaName,
      'given_name' => $this->faker->firstName,
      'given_name_kana' => $this->faker->firstKanaName,
      'email' => $this->faker->unique()->safeEmail,
    ];

    $response = $this->actingAs($this->admin, 'admin')->postJson(route('admin.user.store'), $expects);

    $response->assertCreated()->assertJson([
      'email' => $expects['email'],
    ]);

    $this
      ->assertDatabaseHas('users', [
        'email' => $expects['email'],
      ])
      ->assertDatabaseCount('users', $beforeCount + 1);
  }
}

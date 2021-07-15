<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ChatRoomTest extends TestCase
{

  protected $user;
  protected function setUp(): void
  {
    parent::setUp();
    $this->user = User::first();
  }

  /**
   * @test
   * @group chat_room
   */
  public function should_チャットルーム一覧()
  {
    $response = $this->actingAs($this->user)->getJson(route('chatRoom.findByOwner'));
    $response->assertOk();
    // APIの仕様とデータ形式が一致している
    $result = parent::$openApiValidator->validate('getCurrentAdmin', 200, json_decode($response->getContent(), true));
    $this->assertFalse($result->hasErrors(), $result);
  }
}

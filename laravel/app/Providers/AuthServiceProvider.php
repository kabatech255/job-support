<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Enums\Role as RoleEnum;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'App\Models\MeetingRecord' => 'App\Policies\MeetingRecordPolicy',
    'App\Models\ChatRoom' => 'App\Policies\ChatRoomPolicy',
    'App\Models\ChatMessage' => 'App\Policies\ChatMessagePolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();
    Gate::define('overManager', function ($user) {
      return $user instanceof User && $user->role->value >= RoleEnum::value('manager');
    });
  }
}

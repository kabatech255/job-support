<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\JWTVerifierService;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class CognitoGuard implements Guard
{
  use GuardHelpers;

  /**
   * @var $JWTVerifier
   */
  private $JWTVerifier;

  /**
   * @var $userProvider
   */
  private $request;

  /**
   * @var $userProvider
   */
  private $userProvider;

  /**
   * @param JWTVerifierService $JWTVerifier
   * @param UserProvider $userProvider
   */
  public function __construct(
    JWTVerifierService $JWTVerifier,
    Request $request,
    UserProvider $userProvider
  )
  {
    $this->JWTVerifier = $JWTVerifier;
    $this->request = $request;
    $this->userProvider = $userProvider;
  }

  public function user()
  {
    if ($this->user) {
      return $this->user;
    }

    $decoded = $this->JWTVerifier->decode();

    if ($decoded) {
      $result = $this->userProvider->retrieveByCredentials(['cognito_sub' => $decoded->sub]);
      if (is_null($result)) {
        $registered = $this->create($decoded);
        $result = $this->userProvider->retrieveByCredentials(['cognito_sub' => $registered->cognito_sub]);
      }
      return $result;
    }

    return null;
  }

  public function validate(array $credentials = [])
  {
      throw new \RuntimeException('Cognito guard cannot be used for credential based authentication.');
  }

  private function create($decoded)
  {
    $cognito_username = 'cognito:username';

    return User::updateOrCreate(['cognito_sub' => $decoded->sub], [
      'cognito_sub' => $decoded->sub,
      'email' => $decoded->email ?? '',
      'login_id' => $decoded->{$cognito_username},
      'family_name' => '',
      // 'family_name_kana' => '',
      'given_name' => '',
      // 'given_name_kana' => '',
      'password' => \Hash::make(\Str::random(32)),
      'role_id' => 1,
    ]);
  }
}

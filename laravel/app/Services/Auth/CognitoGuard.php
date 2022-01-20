<?php

namespace App\Services\Auth;

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
      return $this->userProvider->retrieveByCredentials(['cognito_sub' => $decoded->sub]);
    }

    return null;
  }

  public function validate(array $credentials = [])
  {
      throw new \RuntimeException('Cognito guard cannot be used for credential based authentication.');
  }
}

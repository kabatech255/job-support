<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * @return string
   */
  public function username()
  {
    return 'login_id';
  }

  /**
   * @param Request
   * @param User $user
   * @return User
   */
  protected function authenticated(Request $request, $user)
  {
    return $user;
  }

  /**
   * @param Request $request
   */
  protected function loggedOut(Request $request)
  {
    // Auth::logout();
    Auth::guard('cognito')->logout();
    $request->session()->regenerate();

    return response()->json();
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
   * @throws \Illuminate\Validation\ValidationException
   */
  public function testLogin(Request $request)
  {
    return $this->login($request);
  }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

  use SendsPasswordResetEmails;

  /**
   * @param Request $request
   * @param string $response
   * @return \Illuminate\Http\JsonResponse
   */
  protected function sendResetLinkResponse(Request $request, $response)
  {
    return response()->json([
      'message' => "パスワード再設定用メールを送信しました。\n数秒後にトップページに移動します。",
      'data' => $response
    ]);
  }

  /**
   * Get the response for a failed password reset link.
   *
   * @param \Illuminate\Http\Request $request
   * @param string $response
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  protected function sendResetLinkFailedResponse(Request $request, $response)
  {
    throw ValidationException::withMessages([
      'email' => [trans($response)],
    ]);
  }
}

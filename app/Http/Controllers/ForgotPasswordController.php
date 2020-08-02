<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return $this->respondWithMessage('Reset password link sent on your email id.');
    }

    public function reset(ResetPasswordRequest $requset)
    {
        $email_password_status = Password::reset($requset->validated(), function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($email_password_status == Password::INVALID_TOKEN) {
            return $this->respondBadRequest(ApiCode::INVALID_RESET_PASSWORD_TOKEN);
        }

        return $this->respondWithMessage("Password successfully changed");
    }
}

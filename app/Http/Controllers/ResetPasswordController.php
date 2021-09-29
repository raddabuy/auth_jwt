<?php

namespace App\Http\Controllers;

use App\Jobs\ResetRequestNotification;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetSuccess;
use App\Traits\ThrowValidationErrorTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ThrowValidationErrorTrait;

    public function createMessage(Request $request)
    {
        $email = $request->get('email');

        $token = str_random(60);
        PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token
            ])
            ->first();

        dispatch(new ResetRequestNotification($email, $token));

        return response()->json([
                'Письмо отправлено на почту'
        ]);
    }

    public function resetPassword(Request $request){

        $email = $request->get('email');
        $password = $request->get('password');
        $token = $request->get('token');


        $passwordReset = PasswordReset::where([
            ['token', $token],
            ['email', $email]
        ])
            ->firstOrFail();


        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            $this->throwValidationError('This password reset token is invalid');
        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();

        $user->update(['password' => bcrypt($password)]);
        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess());

        return response()->json([
            'Пароль успешно изменен'
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use App\Jobs\ResetRequestNotification;
use App\Jobs\SuccessResetNotification;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function createMessage(Request $request)
    {
        $email = $request->get('email');

//        $user = User::where('email', $email)->firstOrFail();

        $token = str_random(60);
        PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token
            ])
            ->first();

//        $user->notify(
//            new PasswordResetRequest($token,$email,$user)
//        );
//        ResetRequestNotification::dispatch($email, $token);
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


//        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
//            $passwordReset->delete();
//
//            $this->throwValidationError('This password reset token is invalid');
//        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();

        $user->update(['password' => bcrypt($password)]);
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess());
//        SuccessResetNotification::dispatch($user);


        return response()->json([
            'Пароль успешно изменен'
        ]);

    }
}

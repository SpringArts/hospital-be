<?php


namespace App\Usecases\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class VerifyEmailAction
{
    public function __invoke($id , $hash)
    {

        $user = User::where('id', $id)->where('email_verification_token', $hash)->first();

        if ($user) {
            $user->markEmailAsVerified();
            $user->update(['is_active' => true]);
                return Redirect::to('https://www.google.com');
//            return Redirect::to(env('FRONTEND_URL') . "/auth/login");
        } else {
            return response()->json([
                'message' => 'Invalid verification link.',
            ], 400);
        }

    }
}

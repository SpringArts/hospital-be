<?php


namespace App\Usecases\Auth;


use App\helper\ResponseHelper;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class RegisterAction
{
    public function __invoke(array $formData)
    {
        $user = User::create([
            'name' => $formData['name'],
            'email' => $formData['email'],
            'password' => $formData['password'],
            'email_verification_token' => Str::uuid()->toString()
        ]);

        Mail::to($user->email)->queue(new VerifyEmail($user));

        return ResponseHelper::success('Please check your email to activate your account.', $user)
    }
}

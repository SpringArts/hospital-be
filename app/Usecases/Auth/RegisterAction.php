<?php


namespace App\Usecases\Auth;


use App\Helpers\ResponseHelper;
use App\Http\Resources\Auth\UserResource;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class RegisterAction
{
    public function __invoke(array $formData)
    {
        try {
            //call login action

            //adding user data to the database
            $user = new User();
            $user->name = $formData['name'];
            $user->email = $formData['email'];
            $user->password = Hash::make($formData['password']);

            //generate email_verification_token to validate user email
            $user->email_verification_token = Str::uuid()->toString();
            $user->save();

            Mail::to($user->email)->send(new VerifyEmail($user));

            return ResponseHelper::success('Please check your email to activate your account.', new UserResource($user), Response::HTTP_OK);
        } catch (\Throwable $th) { //if the error is happening
            return ResponseHelper::fail($th->getMessage(),  500);
        }
    }
}

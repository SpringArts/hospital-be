<?php


namespace App\Usecases\Auth;

use App\Enums\UserRole;
use App\Helpers\ResponseHelper;
use App\Http\Resources\Auth\UserResource;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginAction
{
    const ADMIN_TOKEN  = UserRole::ADMIN;
    const EDITOR_TOKEN  = UserRole::EDITOR;
    const NORMAL_USER_TOKEN = UserRole::USER;

    public function __invoke(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                if (!$user->is_active) {
                    $id = Auth::id();
                    $unActiveUser = User::where('id', $id)->first();
                    Mail::to($unActiveUser->email)->send(new VerifyEmail($unActiveUser));
                    return response()->json(['message' => "Your email isn't verified. Please check your mail to verify your account"], Response::HTTP_UNAUTHORIZED);
                }

                $this->authenticateUser($user);
                $token = $this->generateToken($user);

                return $this->generateSuccessResponse($token, $user);
            }
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(),  500);
        }
    }

    protected function authenticateUser($user)
    {
        \auth()->login($user, true);
    }

    protected function generateToken($user)
    {
        return $user->createToken($user->role === UserRole::ADMIN ? self::ADMIN_TOKEN : self::NORMAL_USER_TOKEN)->plainTextToken;
    }
    protected function generateSuccessResponse($token, $user)
    {
        if ($user->role ===  UserRole::ADMIN) {
            return response()->json([
                'access_token' => $token,
                'token_type' => self::ADMIN_TOKEN,
                'data' => new UserResource($user),
            ]);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => self::NORMAL_USER_TOKEN,
            'data' => new UserResource($user),
        ]);
    }
}

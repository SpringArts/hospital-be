<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Usecases\Auth\RegisterAction;
use App\Usecases\Auth\VerifyEmailAction;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        return (new RegisterAction)($request->all());
    }

    public function verifyEmail(int $id , string $hash)
    {
        return (new VerifyEmailAction)($id , $hash);
    }
}

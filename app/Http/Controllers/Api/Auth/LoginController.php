<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Usecases\Auth\LoginAction;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return (new LoginAction)($request);
    }
}

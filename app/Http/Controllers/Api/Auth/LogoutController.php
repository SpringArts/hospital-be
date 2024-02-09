<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Usecases\Auth\LogoutAction;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout()
    {
        return (new LogoutAction)();
    }
}

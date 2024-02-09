<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendEmailRequest;
use App\Usecases\Auth\ResetPasswordAction;
use App\Usecases\Auth\SendEmailAction;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function sendEmail(SendEmailRequest $request)
    {
        return (new SendEmailAction)($request->all());
    }

    public function reset(ResetPasswordRequest $resquest)
    {
        return (new ResetPasswordAction)($resquest);
    }
}

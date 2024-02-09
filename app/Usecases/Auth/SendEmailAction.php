<?php


namespace App\Usecases\Auth;


use App\helper\ResponseHelper;
use App\Mail\SendCodeResetPasswordMail;
use App\Models\ResetCodePassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class SendEmailAction
{
    public function __invoke(array $data)
    {
        ResetCodePassword::where('email', $data['email'])->delete();
        $code = mt_rand(100000 , 999999);
        $data['code'] = $code;
        $resetCode = ResetCodePassword::create($data);
        Mail::to($data['email'])->send(new SendCodeResetPasswordMail($data['code']));
        return ResponseHelper::success('Please check your email', null , Response::HTTP_OK);
    }
}

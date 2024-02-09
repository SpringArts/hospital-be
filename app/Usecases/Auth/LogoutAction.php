<?php


namespace App\Usecases\Auth;


use App\helper\ResponseHelper;
use Illuminate\Http\Response;

class LogoutAction
{
    public function __invoke()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return ResponseHelper::success("Successfully logout", null , Response::HTTP_OK);
    }
}

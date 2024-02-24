<?php

namespace App\Http\Controllers\Api\App\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Usecases\App\User\UserLogAction;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    protected $userLogAction;

    public function __construct(UserLogAction $userLogAction){
        $this->userLogAction = $userLogAction;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userLogAction->fetchAll();
        return response()->json([
            'data' => $data,
            "meta" => ResponseHelper::getPagination($data),
            "message" => "successfully fetched"
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userLogAction->store($request->all());
    }
}

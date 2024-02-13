<?php


namespace App\Helpers;


use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseHelper
{
    public static function success($message = "success", $data = null, $status = Response::HTTP_OK)
    {
        return \response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function fail($message = "fail", $data = null, $status = Response::HTTP_OK)
    {
        return \response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function getPagination(LengthAwarePaginator $data)
    {
        return [
            'currentPage' => $data->currentPage(),
            'totalPages' => $data->lastPage(),
            'startOffset' => $data->firstItem(),
            'endOffset' => $data->lastItem(),
            'totalItems' => $data->total(),
        ];
    }
}

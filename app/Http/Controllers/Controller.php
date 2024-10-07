<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

abstract class Controller
{
    /**
     * @param array $res_data
     *
     * @return ResponseFactory|Response
     */
    public function success(array $res_data): Response|ResponseFactory
    {
        return response(res_template([
            'status_code' => $res_data['status_code'] ?? 200,
            'message' => $res_data['message'] ?? 'your request was successfully submitted',
            'data' => $res_data['data'] ?? [],
            'meta' => $res_data['meta'] ?? [],
        ]), $res_data['status_code'] ?? 200);
    }

    /**
     * @param array $res_data
     *
     * @return ResponseFactory|Response
     */
    public function error(array $res_data): Response|ResponseFactory
    {
        return response(res_template([
            'status_code' => $res_data['status_code'] ?? 422,
            'success' => false,
            'message' => $res_data['message'] ?? 'Your request has encountered an error',
            'data' => $res_data['data'] ?? [],
        ]), $res_data['status_code'] ?? 422);

    }
}

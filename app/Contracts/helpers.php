<?php

if (!function_exists('res_template')) {
    /**
     * response template array data
     *
     * @param array $data
     *
     * @return array
     */
    function res_template(array $data): array
    {
        return [
            'status_code' => $data['status_code'] ?? 200,
            'success' => $data['success'] ?? true,
            'back' => $data['back'] ?? false,
            'reset' => $data['reset'] ?? false,
            'message' => $data['message'] ?? 'your request was successfully submitted',
            'message_type' => $data['message_type'] ?? 'nothing',
            'message_show_type' => $data['message_show_type'] ?? 'nothing',
            'data' => $data['data'] ?? [],
            'meta' => $data['meta'] ?? [],
            'errors' => $data['errors'] ?? [],
        ];
    }
}

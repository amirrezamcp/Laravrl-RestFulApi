<?php

namespace App\RestFulApi;

class ApiResponseBuilder
{
    private ApiResponse $response;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->response = new ApiResponse;
    }

    public function withMessage(string $message)
    {
        $this->response->setMessage($message);
        return $this;
    }

    public function withData(mixed $data)
    {
        $this->response->setData($data);
        return $this;
    }

    public function withStatus(int $status)
    {
        $this->response->setStatus($status);
        return $this;
    }

    public function withAppends(array $appends)
    {
        $this->response->setappends($appends);
        return $this;
    }

    public function build(): ApiResponse
    {
        return $this->response;
    }
}

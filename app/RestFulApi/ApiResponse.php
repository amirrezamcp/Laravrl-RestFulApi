<?php

namespace App\RestFulApi;

class ApiResponse
{
    private ?string $message = null;

    private mixed $data = null;

    private int $status = 200;

    private array $appends = [];


    /**
     * Set the value of message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the value of appends
     *
     * @return  self
     */
    public function setAppends($appends)
    {
        $this->appends = $appends;

        return $this;
    }

    public function response()
    {
        $body = [];
        !is_null($this->message) && $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        $body = $body + $this->appends;
        return response()->json($body, $this->status);
    }
}

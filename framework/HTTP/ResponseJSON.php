<?php

namespace GF\HTTP;

class ResponseJSON
{

    protected array $info = [];

    protected array $data = [];

    protected array $meta = [];

    protected array $http = [
        'code' => 200
    ];


    public function success(array $data = [])
    {
        $this->info = ['status' => 'success'];
        $this->data = $data;
        return $this;
    }

    public function error(string $errorMessage,array $data = [])
    {
        $this->info = ['status' => 'error','message' => $errorMessage];
        $this->data = $data;
        return $this;
    }

    public function exception(\Exception|\Error $exception)
    {
        if($exception->getCode()!=0) {
            $this->http['code'] = $exception->getCode();
        }
        $this->info = [
            'status' => 'error',
            'message' => $exception->getMessage(),
            'exception' => true
        ];
        return $this;
    }

    public function render()
    {
        http_response_code($this->http['code']);
        header('Content-Type: application/json');
        $this->info['time_work'] = timeWork();
        $result = [
            'info' => $this->info,
            'data' => $this->data,
        ];
        if(!empty($this->meta)) {
            $result['meta'] = $this->meta;
        }
        echo json_encode($result);
    }


}
<?php

namespace GF\HTTP;

class ResponseJSON
{

    protected array $info = [];

    protected array $data = [];

    protected array $meta = [];


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
        $this->info = [
            'status' => 'error',
            'message' => $exception->getMessage(),
            'exception' => true
        ];
        return $this;
    }

    public function render()
    {
        header('Content-Type: application/json');
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
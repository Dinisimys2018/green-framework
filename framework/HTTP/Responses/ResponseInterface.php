<?php

namespace GF\HTTP\Responses;

interface ResponseInterface
{
    public function render();

    public function exception(\Throwable $exception):self;

}
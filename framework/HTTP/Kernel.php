<?php

namespace GF\HTTP;

use GF\Core\Interfaces\KernelInterface;

class Kernel implements KernelInterface
{

    public function load():static
    {
        app(Route::class)->loadData();
        return $this;
    }

    public function handle()
    {
        try {
            $route = app(Route::class)->current();
            $response = app()->call(
                $route['controller'],
                $route['action'],
                $route['params']
            );
        } catch (\Throwable $exception)
        {
            $response = app(\App\Exceptions\Handler::class)->responseHTTP($exception);
        }
        $response->render();
    }

}
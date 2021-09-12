<?php

namespace GF\HTTP;

class Handler
{
    public static function run()
    {
        try {
            app(Route::class)->loadData();
            $route = app(Route::class)->current();
            $response = app()->call(
                $route['controller'],
                $route['action'],
                $route['params']
            );
        } catch (\Exception|\Error $exception)
        {
            $response = app(\App\Exceptions\Handler::class)->responseHTTP($exception);
        }
        $response->render();

    }

}
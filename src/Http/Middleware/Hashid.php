<?php

namespace Jiaxincui\Hashid\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Hashid
{
    /**
     * @param $request
     * @param Closure $next
     * @param array ...$parameter
     * @return mixed
     */
    public function handle($request, Closure $next, ...$parameter)
    {
        $router = Route::current();
        if ($router->hasParameters()) {
            $parameterNames = $router->parameterNames();
            if (! empty($parameter)) {
                foreach ($parameter as $v) {
                    $this->decodeParameter($router, $v);
                }
            } else {
                foreach ($parameterNames as $v) {
                    $this->decodeParameter($router, $v);
                }
            }
        }
        return $next($request);
    }

    private function decodeParameter($router, $parameterName)
    {
        if ($router->hasParameter($parameterName)) {
            $code = $router->parameter($parameterName);
            $router->setParameter($parameterName, id_decode($code));
        }
    }
}

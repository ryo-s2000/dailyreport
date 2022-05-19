<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use OpenTracing\GlobalTracer;
use Illuminate\Support\Facades\Route;

class Jaeger
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param null|string              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $tracer = GlobalTracer::get();
        $scope = $tracer->startActiveSpan(Route::currentRouteAction(), []);

        $response = $next($request);

        $scope->close();
        $tracer->flush();

        return $response;
    }
}

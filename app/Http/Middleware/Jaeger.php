<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use OpenTracing\GlobalTracer;
use Illuminate\Support\Facades\Route;
use DB;

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
        $scope = $tracer->startSpan(Route::currentRouteAction(), []);

        // main
        DB::enableQueryLog();
        $response = $next($request);
        // main

        // query log
        $rowQueryLog = collect(DB::getQueryLog());
        $queryLog = $rowQueryLog->pluck('time', 'query')->sortBy('time');
        // ->pluck('time', 'query');
        $scope->log(['query_log' => $queryLog]);
        // query log

        $scope->finish();
        $tracer->flush();

        return $response;
    }
}

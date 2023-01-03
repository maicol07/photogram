<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}

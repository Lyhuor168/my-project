<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Default to Khmer if no session locale set
        $locale = session('locale', 'km');

        if (in_array($locale, ['en', 'km'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
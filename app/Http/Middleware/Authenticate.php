<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Authenticate
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::check()) {
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('login')
                ->with('error', 'សូម Login មុន!');
        }
        return $next($request);
    }
}

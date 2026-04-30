<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'សូម Login មុន!');
        }
        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'អ្នកមិនមានសិទ្ធិចូលទំព័រនេះ!');
        }
        return $next($request);
    }
}

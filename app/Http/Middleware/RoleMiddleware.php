<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $action = $request->route()->getAction();
        $middlewares = $action['middleware'] ?? [];

        foreach ($middlewares as $middleware) {
            if (str_starts_with($middleware, 'role:')) {
                $role = explode(':', $middleware)[1]; 
        // dd($role);
                
                // Check if the user is authenticated and has the role
                if (Auth::user()->department !== $role) {
                    abort(403, 'Unauthorized action.');
                }
            }
        }

        return $next($request);
    }
}

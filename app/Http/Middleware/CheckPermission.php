<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = Auth::guard('admin')->user();
        
        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // Option 1: Using Laravel's Gate system
        // if (Gate::forUser($user)->allows($permission)) {
        //     return $next($request);
        // }

        // Option 2: If using Spatie Permission (uncomment below and comment above)
        // if ($user->can($permission)) {
        //     return $next($request);
        // }

        // Option 3: Custom permission checking method
        // if ($user->hasPermission($permission)) {
        //     return $next($request);
        // }

        return response()->json([
            'message' => 'This user does not have the required permission'
        ], 403);
    }
}
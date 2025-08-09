<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class ClientStatus
{
    /**
     * Handles an incoming request, checking if a client is active.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the currently authenticated client user.
        $user = Auth::guard('client')->user();

        // If a user is found and their status is '1' (active), allow the request to proceed.
        if ($user && $user->status == 1) {
            return $next($request);
        }

        // If the user is not authenticated as a client or their status is not '1',
        // deny access with a 403 Forbidden error.
        return abort(403, 'Unauthorized');
    }
}

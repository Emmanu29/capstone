<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckIsDeleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle($request, Closure $next){
        if (Auth::check() && Auth::user()->category == 'Temporary User') {
            $user = Auth::user();

            // Log user data for debugging purposes
            Log::info('User Data:', ['id' => $user->id, 'email' => $user->email, 'isDeleted' => $user->isDeleted, 'category' => $user->category]);

            // Check if the user is not an admin user and is marked as deleted
            if ($user->isDeleted == 1) {
                Auth::logout();
                //return redirect('/login')->withErrors(['message' => 'Your account has been deleted. Please contact support for assistance.']);
            }
        }
        return $next($request);
    }

}

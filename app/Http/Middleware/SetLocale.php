<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the session has a 'locale' value set
        if($request->session()->has('locale')){

            // Set the application's locale based on the value stored in the session, defaulting to 'en' if not found
            App::setLocale($request->session()->get('locale', 'en'));
        }

        // Pass the request to the next middleware or request handler
        return $next($request);
    }
}

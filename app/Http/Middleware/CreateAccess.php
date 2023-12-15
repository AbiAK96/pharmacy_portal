<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CreateAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(tenant('enable_create') == true){
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Alreadylogin
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
        $req = $request->url();
        if (!empty($req)) {
            if( session()->has('LoggedUser') && ((url('buyer/login') === $req)
                || ( url('buyer/register') ===  $req  )
                || ( url('buyer/forgot') ===  $req  )
                || ( url('buyer/reset') ===  $req  ))
            ){
                return back();
            }
        }
        return $next($request);
    }
}

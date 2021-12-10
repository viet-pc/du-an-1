<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HandleOrder
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
        $user_role = DB::table('users')
            ->join('role','users.UserRole', '=', 'role.id_role')
            ->where('UserId', '=', Session('LoggedUser'))
            ->value('RoleName');
        if($user_role == 'HRM'){
            return redirect('/SoMeThInGwEnTwRoNg');

        } else {
            return $next($request);

        }
    }
}

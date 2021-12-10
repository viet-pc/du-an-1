<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role_check1, $role_check2, $role_check3)
    {
        $user_role = DB::table('users')
            ->join('role','users.UserRole', '=', 'role.id_role')
            ->where('UserId', '=', Session('LoggedUser'))
            ->value('RoleName');
        $role = array($role_check1, $role_check2, $role_check3);
        if(in_array($user_role,$role)){
            return $next($request);
        }else{
            return redirect('/SoMeThInGwEnTwRoNg');
        }
    }
}

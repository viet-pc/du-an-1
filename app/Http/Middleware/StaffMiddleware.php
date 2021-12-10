<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //check for staff's role, if not, redirect to eror page
        $user_role = DB::table('users')->where('UserId', '=', Session('LoggedUser'))->value('UserRole');
        $not_staff = 6; //RoleID of customer
        if ($user_role == $not_staff) {
            return redirect('/SoMeThInGwEnTwRoNg');
        }

        //set session for middleware role check
        $logged_role = DB::table('users')
            ->join('role','users.UserRole', '=', 'role.id_role')
            ->where('UserId', '=', Session('LoggedUser'))
            ->value('RoleName');
        Session::put('UserRole', $logged_role);

        //set session for each permission
        $get_permissions = DB::table('user_per')
            ->join('permission', 'user_per.id_per', '=', 'permission.id_per')
            ->select('permission.name_per')
            ->where('user_per.id_user', '=', Session('LoggedUser'))
            ->where('user_per.licenced', '=',  '1')
            ->get();
        $permissions = array();
        //push value from query builder into array $permission
        foreach ($get_permissions as $permission) {
            array_push($permissions, $permission->name_per);
        }
        //now permissions have array of permission's name
        foreach ($permissions as $permission) {
            Session::put($permission, $permission);
            //if staff have "Create" and "View" permission, we will have Session('Create') and Session('View');
        }

        return $next($request);
    }
}

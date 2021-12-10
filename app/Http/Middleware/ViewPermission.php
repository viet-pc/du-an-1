<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ViewPermission
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
        $userID = Session::get('LoggedUser');
//        //check for view permission
//        $action = 'VIEW';
//        $permission_check = 2; //database set of View permission
//        $test = DB::table('users')
//            ->join('user_per','users.UserID','=','user_per.id_user')
//            ->join('permission','user_per.id_per','=','permission.id_per')
//            ->join('permission_detail','permission.id_per','=','permission_detail.id_per')
//            ->where('users.UserID','=', $userID)
//            ->where('user_per.id_per', '=' , $permission_check)
//            ->where('user_per.licenced', '=',  '1')//licenced: 1 = true, 0 = false
//            ->where('action_code', '=', $action)//action code in permission detail
//            ->value('name_per');
//        ;
//        //make an array for check exist later, push first value of permission check
//        $permissions = array($test);
//
//        //check for Full permission
//        $permission_check = 1; //database set of Full permission, this must be default on every
//        $test = DB::table('users')
//            ->join('user_per','users.UserID','=','user_per.id_user')
//            ->join('permission','user_per.id_per','=','permission.id_per')
//            ->join('permission_detail','permission.id_per','=','permission_detail.id_per')
//            ->where('users.UserID','=', $userID)
//            ->where('user_per.id_per', '=' , $permission_check)
//            ->where('user_per.licenced', '=',  '1')//licenced: 1 = true, 0 = false
//            ->where('action_code', '=', $action)//action code in permission detail
//            ->value('name_per');
//        ;
//        array_push($permissions,$test);
//        if(in_array('Full',$permissions)){
//            //have permission
//            return $next($request);
//        }elseif (in_array('View',$permissions)){
//            //have permission
//            return $next($request);
//        }else{
//            //no permission
//            return redirect('/SoMeThInGwEnTwRoNg');
//        }
        $test = DB::table('users')
            ->join('user_per','users.UserID','=','user_per.id_user')
            ->join('permission','user_per.id_per','=','permission.id_per')
            ->join('permission_detail','permission.id_per','=','permission_detail.id_per')
            ->where('users.UserID','=', $userID)
            ->where('user_per.licenced', '=',  '1')//licenced: 1 = true, 0 = false
            ->where('action_code', '=', 'VIEW')//action code in permission detail
            ->value('check_action');
        if($test == 1){
            return $next($request);
        }else{
            return redirect('/SoMeThInGwEnTwRoNg');
        }
    }
}

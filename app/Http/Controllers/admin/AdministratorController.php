<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdministratorController extends Controller
{
    function index()
    {
        $admins = DB::table('users')
            ->join('role', 'role.id_role', '=', 'users.UserRole')
            ->select('users.UserId', 'users.Fullname', 'users.Email', 'role.RoleName', 'active')
            ->where('users.UserRole', '!=', '6')
            ->get();
        $super_admin = DB::table('users')//check super admin so với hr
            ->join('role', 'UserRole', '=', 'id_role')
            ->where('users.UserId', '=', Session('LoggedUser'))
            ->value('RoleName');
        $page = 'administrator';
        return view('admin/administrator', compact('admins', 'page','super_admin'));
    }

    function add()
    {
        //check role of logging user
        $this_user_role = DB::table('users')
            ->join('role', 'UserRole', '=', 'id_role')
            ->where('users.UserId', '=', Session('LoggedUser'))
            ->value('id_role');

        //check logging user's role is supper admin or not, cuz only supper admin can create new manager or supper admin
        if ($this_user_role == 5) {
            $listRole = DB::table('role')
                ->where('RoleName', '!=', 'Customer')
                ->get();
        } else {
            $listRole = DB::table('role')
                ->where('RoleName', '!=', 'Manager')
                ->where('RoleName', '!=', 'SuperAdmin')
                ->where('RoleName', '!=', 'Customer')
                ->get();
        }
        return view('admin/addAdminstrator', compact('listRole'));
    }

    function delete($id, Request $request)
    {
        $delete = DB::table('users')->where('UserId', '=', $id)->delete();
        if ($delete) {
            $request->session()->put('status', 'success/xóa thành công');
        } else {
            $request->session()->put('status', 'danger/xóa không thành công đã có lỗi xãy ra');
        }
        return back();
    }

    function update($id,Request $request)
    {
        $request->session()->put('updateId',$id);
        $user = DB::table('users')
            ->select('UserRole','UserID', 'Fullname', 'Email', 'Active')
            ->where('UserId', '=', $id)
            ->first();
        //check role of logging user
        $this_user_role = DB::table('users')
            ->join('role', 'UserRole', '=', 'id_role')
            ->where('users.UserId', '=', Session('LoggedUser'))
            ->value('id_role');

        //check logging user's role is supper admin or not, cuz only supper admin can create new manager or supper admin
        if ($this_user_role == 5) {
            $listRole = DB::table('role')
                ->where('RoleName', '!=', 'Customer')
                ->get();
        } else {
            $listRole = DB::table('role')
                ->where('RoleName', '!=', 'Manager')
                ->where('RoleName', '!=', 'SuperAdmin')
                ->where('RoleName', '!=', 'Customer')
                ->get();
        }
        return view('admin/updateAdminstrator', compact('listRole', 'user'));
    }

    function postUpdate(Request $request)
    {
        $message = [
            'required' => 'Chưa nhập :attribute',
            'email' => 'Vui lòng nhập email',
            'unique' => 'email Đã đăng ký'
        ];
        //validate request
        $validate = Validator::make($request->all(), [
            'Fullname' => 'required|string',
            'role' => 'required',
            'email' => 'required|email'
        ], $message);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $user = DB::table('users')
            ->where('UserId','=',$request->session()->get('updateId'))
            ->select('email')
            ->get();
        $requestEmail = $request->email;
        if($user['0']->email !== $request->email){
            $emails = DB::table('users')->select('email')->get();
            foreach($emails as $value) {
                if($value->email === $requestEmail){
                    $request->session()->put('status', 'danger/email đã tồng tại');
                    return back();
                }
            }
        }
        $query = DB::table('users')
            ->where('UserId', '=', $request->session()->get('updateId'))
            ->update([
                'Email' => $request->email,
                'fullname' => $request->Fullname,
                'UserRole' => $request->role,
                'Active' => $request->status,
            ]);
        $request->session()->forget('updateId');
        if ($query) {
            $request->session()->put('status', 'success/Cập nhật thành công');
        } else {
            $request->session()->put('status', 'danger/Cập nhật không thành công đã có lỗi xãy ra');
        }
        return back();
    }

    function postAdd(Request $request)
    {
        $message = [
            'required' => 'Chưa nhập :attribute',
            'email' => 'Vui lòng nhập đúng định dạng email',
            'unique' => 'Email đã đăng ký'
        ];
        //validate request
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'Fullname' => 'required|string',
            'role' => 'required',
        ], $message);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }


        $token = Str::random(150);
        $passwordRandom = Str::random(150);
        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token]
        );

        Mail::send('buyer/verify',['token' => $token,'email' => $request->email], function($message) use ($request) {
            $message->from('vietpcps15786@fpt.edu.vn');
            $message->to($request->email);
            $message->subject('bạn đã được tạo tài khoản quản trị bên metah với chức vụ '.$request->role.' \n vui lòng đặt lại mật khẩu');
        });
        $query = DB::table('users')->insert([
            'fullname' => $request->Fullname,
            'UserRole' => $request->role,
            'Active' => $request->status,
            'email' => $request->email,
            'password' => Hash::make($passwordRandom)
        ]);

        //automatic add permission for new user
        if($request->role == 5 || $request->role == 4){//super admin or manager
            $permission_action = 1;//1 is Full permission
        }else{
            $permission_action = 2;//2 is View only
        }
        $last_created_user = DB::table('users')->latest('UserId')->value('UserId');
        DB::table('user_per')->insert([
            'id_per' => $permission_action,//view or full permission
            'id_user' => $last_created_user,
            'licenced' => 1,//active
        ]);

        if ($query) {
            $request->session()->put('status', 'success/Thêm thành công');
        } else {
            $request->session()->put('status', 'danger/Thêm không thành công đã có lỗi xãy ra');
        }
        return back();
    }
}

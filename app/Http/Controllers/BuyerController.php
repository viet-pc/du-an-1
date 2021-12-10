<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BuyerController extends Controller
{

    function login(Request $request)
    {

        $preUrl = explode( $request->getSchemeAndHttpHost(),url()->previous() )[1];
        $urlCut = explode('/',$preUrl)[1];
        if($urlCut !== 'buyer'){
            if($urlCut==='admin'){
               $urlBack = $request->getSchemeAndHttpHost().'/admin';
            }else{
                $urlBack = url()->previous();
            }
            $request->session()->put('backUrl',$urlBack);
        }

        return view('buyer/buyer')->with('page', 'login');
    }
    function register()
    {
        return view('buyer/buyer')->with('page', 'register');
    }
    function forgot(){
        return view('buyer/buyer')->with('page', 'forgot');
    }
    public function postEmail(Request $request)
    {

        $message =[
            'required'=> 'Bạn chưa nhập email',
            'email' => 'Vui lòng nhập đúng định dạn email',
            'exists'=> 'Tài khoản chưa đăng ký',
        ];
        $validate = Validator::make($request->all(),[
            'email' => 'required|email|exists:users'
        ],$message);
        if($validate->fails()){
            return redirect('buyer/forgot')->withErrors($validate)->withInput();
        }
        $token = Str::random(150);
        $check = DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token]
        );
        Mail::send('buyer/verify',['token' => $token,'email' => $request->email], function($message) use ($request) {
            $message->from('vietpcps15786@fpt.edu.vn');
            $message->to($request->email);
            $message->subject('Thông báo đặt mật khẩu');
        });
        $request->session()->put('email', $request->email);
        $request->session()->put('status', 'success/Chung tôi đã gửi cho bạn email xác thực mật khẩu mới');
        return redirect('buyer/forgot');
    }
    function insertUser(Request $request)
    {

//        validate request
        $message = [
            'required' => 'Vui lòng nhập :attribute',
            'email.unique' => 'Email đã được đăng ký',
            'email' => 'Vui lòng nhập đúng định dạng email',
            'password.min' => 'Các kí tự không đươc ít hơn 6',
            'password.max' => 'Các kí tự không đươc nhiều hơn 50',
            'name.min' => 'Họ và Tên không đươc ít hơn 5',
            'name.max' => 'Họ và Tên không đươc nhiều hơn 100',
            'confirmed' => 'Nhập lại mật khẩu không chính xác'
        ];
        $validate = Validator::make($request->all(),[
            'name' => 'required|min:5|max:100',
            'password' => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
            'email' => 'required|email|unique:users',
        ],$message);

        if ($validate->fails()) {
            return redirect('buyer/register')->withErrors($validate);
        }

        //insert data into database
//        $user = new User();
//        $user->fullname = $request->name;
//        $user->email = $request->email;
//        $user->password = Hash::make($request->password);
//        $save = $user->save();
        // use query builder
        $query = DB::table('users')->insert([
            'fullname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if ($query) {
            return redirect('/buyer/login')->with('status', 'Tạo mới tài khoản thành công');
        } else {
            return redirect('/buyer/register')->with('status', 'Đã có lỗi sảy ra,hảy thử lại sau');
        }
    }

    function check(Request $request)
    {
        $message = [
            'loginEmail.required' => 'Chưa nhập Email',
            'loginPassword.required' => 'Chưa nhập Password',
            'loginEmail.email' => 'Vui lòng nhập đúng định dạng email',
            'loginPassword.min' => 'Các kí tự không đươc ít hơn 6',
            'loginPassword.max' => 'Các kí tự không đươc nhiều hơn 50'
        ];
        //validate request
        $validate = Validator::make($request->all(), [
            'loginEmail' => 'required|email',
            'loginPassword' => 'required|min:6|max:50'
        ],$message);
        if ($validate->fails()) {
            return redirect('/buyer/login')->withErrors($validate)->withInput();
        }

        //if form validate successfully, process login
//        $user = User::where('email' ,'=',$request->loginEmail )->first();
        $user = DB::table('users')->where('email', $request->loginEmail)->where('active','=','1')->first();

        if ($user) {
            if (Hash::check($request->loginPassword, $user->Password)) {
                $request->session()->put('LoggedUser', $user->UserId);
                $request->session()->put('LoggedUserName', $user->Fullname);
                $request->session()->put('LoggedEmail', $request->loginEmail);

                return redirect($request->session()->get('backUrl'));
            } else {
                return redirect('/buyer/login')->with('status', 'Mật khẩu không chính xác');
            }
        } else {
            return redirect('/buyer/login')->with('status', 'Tài khoản không tồn tại ');
        }
    }

//    function profile()
//    {
//        if (session()->has('LoggedUser')) {
//            $user = User::where('UserId', '=', session('LoggedUser'))->first();
//            $data = [
//                'loggedUserInfo' => $user
//            ];
//            return view('test', $data);
//        }
//    }

    public function reset($token,$email) {
        return view('buyer.reset', ['token' => $token,'email' =>$email]);
    }

    public function resetToken(Request $request)
    {
        $message = [
            'required' => 'Chưa nhập :attribute',
            'email' => 'Vui lòng nhập đúng định dạng email',
            'password.min' => 'Các kí tự không đươc ít hơn 6',
            'password.max' => 'Các kí tự không đươc nhiều hơn 50',
            'confirmed' => 'Xác nhậ mật khẩu không chính xác'
        ];
        //validate request
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
        ],$message);
        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if(!$updatePassword)
            return back()->with('status', 'Mã không  còn sử dụng ')->withInput();

        $user = DB::table('users')->where('email','=', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        $request->session()->put('status', 'success/Mật khẩu của bạn đã được thay đổi');
        return redirect('buyer/login');
    }
    function logout()
    {
        if (session()->has('LoggedUser')) {
            session()->flush();
        }
        return redirect('/buyer/login');
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class userController extends Controller
{
    public function index(){
        $data = DB::table('users')
                ->get();
        return view('admin.user.list', compact('data'));
    }

    public function detail($id){
        $data = DB::table('users')
                ->where('UserId', $id)
                ->first();
        $orders = DB::table('orders')
                    ->where('UserId', $id)
                    ->join('status', 'orders.StatusId', 'status.StatusId')
                    ->orderByDesc('orders.OrderId')
                    ->get();
        return view('admin.user.details', compact('data', 'orders'));
    }

    public function update($id, Request $request){
        $rs = [
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý",
            "success" => false
        ];
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $address = $request->input('address');
        $warning = "";
        if($name == '' || $name == null){
            $warning .= "Bạn chưa điền tên<br>";
        }
        if($phone == "" || $phone == null || (preg_match('/^[0-9]{10}+$/', $phone)) == false){
            $warning .= "Số điện thoại thiếu hoặc không đúng định dạng<br>";
        }
        if($email == "" || $email == null || (!filter_var($email, FILTER_VALIDATE_EMAIL))){
            $warning .= "Email thiếu hoặc không đúng định dạng<br>";
        }
        if($address == "" || $address == null){
            $warning .= "Email thiếu hoặc không đúng định dạng<br>";
        }
        $emailReady = DB::table('users')->where('Email',$email)->where('UserId', '!=', $id)->first();
        if($emailReady){
            $warning .= "Email đã có người sử dụng<br>";
        }
        if($warning == ""){
            $affected = DB::table('users')
            ->where('UserId', $id)
            ->update([
                'Fullname' => $name,
                'Email' => $email,
                'Phone' => $phone,
                'Address' => $address
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Cập nhật thành công"
            ];
        }else{
            $rs["messages"] = $warning;
        }
        return response()->json($rs);

    }
    public function active($id){
        $rs = [
            "success" => false,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != null && $id != ""){
            $affected = DB::table('users')
                        ->where('UserId', $id)
                        ->update([
                            'Active' => 1
                        ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Kích hoạt thành công"
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" => "Có lỗi trong quá trình xử lý"
            ];
        }
        return response()->json($rs);
    }

    public function unactive($id){
        $rs = [
            "success" => false,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != null && $id != ""){
            $affected = DB::table('users')
                        ->where('UserId', $id)
                        ->update([
                            'Active' => 0
                        ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Khoá thành công"
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" => "Có lỗi trong quá trình xử lý"
            ];
        }
        return response()->json($rs);
    }


    public function changePassword($id, Request $request){
        $rs = [
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý",
            "success" => false
        ];
        $password = $request->input('password');
        $repeatPassword = $request->input('repeatPassword');
        $warning = "";
        if($repeatPassword == "" || $password == null || $password == "" || $repeatPassword == null){
            $warning = "Bạn nhập thiếu thông tin";
        }
        if($password != $repeatPassword){
            $warning = "2 mật khẩu bạn nhập không giống nhau";
        }
        if(strlen($password) <6){
            $warning = "Mật khẩu cần lớn hơn 6 ký tự";
        }
        if($warning == ""){
            $affected = DB::table('users')
            ->where('UserId', $id)
            ->update([
                'Password' => Hash::make($password)
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Cập nhật thành công"
            ];
        }else{
            $rs["messages"] = $warning;
        }
        return response()->json($rs);
    }

    function rankView(){
        $data = DB::table('users')
        ->join('orders', 'orders.UserId', '=', 'users.UserId')
        ->select('users.UserId', 'users.Fullname', DB::raw('ifnull(count(*), 0) as count'), DB::raw('ifnull(count(*), 0) as count'), DB::raw('sum(ToPay) as sum'))
        ->groupBy('users.UserId', 'users.Fullname')
        ->where('orders.StatusId', 4)
        ->orderByDesc('sum')
        ->get()
        ->each(function ($row, $index) {
            $row->no = $index + 1;
        });
        return view('admin.user.topBuy', compact('data'));
    }
}

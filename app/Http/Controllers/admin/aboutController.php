<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class aboutController extends Controller
{
    function index(){
        $data = DB::table('about')
                ->select('content')
                ->first();
        return view('admin.about', compact('data'));
    }

    function update(Request $request){
        $content = $request->input('content');
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($content != null && $content != ""){
            $affected = DB::table('about')
            ->where('AboutID', 1)
            ->update([
                'content' => $content
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Cập nhật thành công"
            ];
        }else{
            $rs['mesages'] = "Bạn chưa nhập nội dung";
        }
        return response()->json($rs);
    }

    public function setupView(){
        $data = DB::table('about')
                ->where('AboutID', 1)
                ->first();
        return view('admin.infomationSetup', compact('data'));
    }

    public function informationUpdate(Request $request){
        $name = $request->input('Name');
        $phone = $request->input('Phone');
        $address = $request->input('Address');
        $facebook = $request->input('Facebook');
        $instagram = $request->input('Instagram');
        $zalo = $request->input('Zalo');
        $logo = $request->input('Logo');
        $openTime = $request->input('OpenTime');
        $closeTime = $request->input('CloseTime');
        $email = $request->input('Email');
        $wrong = "";
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($name == null || $name == ""){
            $wrong .= "Không để trống tên thương hiệu";
        }
        if($phone == null || $phone == ""){
            $wrong .= "Không để trống số điện thoại";
        }
        if($address == null || $address == ""){
            $wrong .= "Không để trống số điện thoại";
        }
        if($facebook == null || $facebook == ""){
            $wrong .= "Không để trống liên kết Facebook";
        }
        if($instagram == null || $instagram == ""){
            $wrong .= "Không để trống liên kết Instagram";
        }
        if($zalo == null || $zalo == ""){
            $wrong .= "Không để trống liên kết Zalo";
        }
        if($email == null || $email == ""){
            $wrong .= "Không để trống địa chỉ Email";
        }
        if($wrong == ""){
            $affected = DB::table('about')
            ->where('AboutID', 1)
            ->update([
                'Name' => $name,
                'Phone' => $phone,
                'Address' => $address,
                'Facebook' => $facebook,
                'Instagram' => $instagram,
                'Zalo' => $zalo,
                'Logo' => $logo,
                'Email' => $email,
                'OpenTime' => $openTime,
                'CloseTime' => $closeTime,
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Cập nhật thành công"
            ];
        }else{
            $rs['messages'] = $wrong;
        }
        return response()->json($rs);
    }

    public function getInfomation(){
        $data = DB::table('about')
                ->first();
        $rs = [
            "logoUrl" => asset('images/blog').'/'.$data->Logo,
            "name" => $data->Name,
            "email" => $data->Email,
            "phone" => $data->Phone,
            "openTime" => date('G:i', strtotime($data->OpenTime)),
            "closeTime" => date('G:i', strtotime($data->CloseTime)),
            "facebook" => $data->Facebook,
            "instagram" => $data->Instagram,
            "zalo" => $data->Zalo,
            "address" => $data->Address,
        ];
        return response()->json($rs);
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    public function config_permission()
    {
        $admins = DB::table('users')
            ->join('role', 'role.id_role', '=', 'users.UserRole')
            ->select('users.UserId', 'users.Fullname', 'users.Email', 'role.RoleName', 'active')
            ->where('users.UserRole', '!=', '6')
            ->where('users.UserId', '!=', Session('LoggedUser'))
            ->get();
        return view('admin/configuration/permissionConfig', compact('admins'));
    }

    public function get_not_have_permission($user)
    {
        $permission_check = DB::table('user_per')
            ->join('permission', 'user_per.id_per', '=', 'permission.id_per')
            ->select('permission.id_per')
            ->where('user_per.id_user', '=', $user)
            ->get();//edit create view
        $test = array();
        foreach ($permission_check as $permission) {
            array_push($test, $permission->id_per);
        }
        $not_exist_permission = DB::table('permission')
            ->select('id_per', 'name_per')
            ->whereNotIn('id_per', $test)
            ->get();//edit create view
        return $not_exist_permission;
    }

    public function update_config_permission(Request $request)
    {
        $user = $request->input('PermissionUser');
        $permission = $request->input('PermissionAction');
        DB::table('user_per')->insert([
            'id_per' => $permission,
            'id_user' => $user,
            'licenced' => 1
        ]);
        return redirect('/admin/config-permission')->with('add_success', 'Thêm quyền thành công');
    }

    public function check_user_permission($user)
    {
        $permission_check = DB::table('user_per')
            ->join('permission', 'user_per.id_per', '=', 'permission.id_per')
            ->select('permission.name_per', 'permission.id_per')
            ->where('user_per.id_user', '=', $user)
            ->get();
        return $permission_check;
    }

    public function get_permission_licenced($permission, $userID)
    {
        $licenced_check = DB::table('user_per')
            ->where('id_per', '=', $permission)
            ->where('id_user', '=', $userID)
            ->value('licenced');
        return $licenced_check;
    }

    public function update_config_licenced(Request $request)
    {
        $user = $request->input('LicencedUser');
        $permission = $request->input('LicencedUserPermission');
        $licenced = $request->input('LicencedStatus');

        DB::table('user_per')
            ->where('id_user', '=', $user)
            ->where('id_per', '=', $permission)
            ->update([
                'licenced' => $licenced
            ]);
        return redirect('/admin/config-permission')->with('licenced', 'Cập nhật giấy phép thành công!');
    }


    public function config_payment()
    {
        return view('admin/configuration/paymentConfig');
    }

    public function config_shipfee()
    {
        $inside = DB::table('shipoption')
            ->select('ShipOptionId', 'PricePerKm')
            ->where('ShipOptionId', '=', 1)
            ->first();

        $outside = DB::table('shipoption')
            ->select('ShipOptionId', 'PricePerKm')
            ->where('ShipOptionId', '=', 2)
            ->first();
        return view('admin/configuration/shippingConfig', compact('inside', 'outside'));
    }

    public function update_config_shipfee(Request $request)
    {
        $inside = $request->input('Inside');
        DB::table('shipoption')
            ->select('ShipOptionId', 'PricePerKm')
            ->where('ShipOptionId', '=', 1)
            ->update([
                'PricePerKm' => $inside
            ]);

        $outside = $request->input('Outside');
        DB::table('shipoption')
            ->select('ShipOptionId', 'PricePerKm')
            ->where('ShipOptionId', '=', 2)
            ->update([
                'PricePerKm' => $outside
            ]);
        return back()->with('update-shipfee-success', 'Cập nhật phí vận chuyển thành công');
    }

    public function config_slider()
    {
        $sliders = DB::table('slider')->get();
        return view('admin/configuration/sliderConfig', compact('sliders'));
    }//view

    public function config_add_slider()
    {
        return view('admin/configuration/addSliderConfig');
    }//view create

    public function add_slider(Request $request)
    {
        $file = $request->SliderImage;
        $file_name = $file->getClientOriginalName();
        $file->move(base_path('public/images/slider'), $file_name);
        DB::table('slider')
            ->insert([
                'Images' => $file_name,
                'URL' => $request->LinkToContent,
                'Discount' => $request->SaleContent,
                'Content' => $request->EventContent,
                'Active' => $request->SliderActive
            ]);
        return back()->with('add-success','Tạo Slider Thành Công');
    }//action create

    public function config_edit_slider($id){
        $edit = DB::table('slider')
            ->where('SliderId','=',$id)
            ->first();
        Session::put('slider-edit', $edit->Images);
        return view('admin/configuration/editSliderConfig', compact('edit'));
    }

    public function update_slider(Request $request)
    {
        if($request->SliderImage == null){
            $file_name = Session('slider-edit');
        }else{
            $file = $request->SliderImage;
            $file_name = $file->getClientOriginalName();
            $file->move(base_path('public/images/slider'), $file_name);
        }
        DB::table('slider')
            ->where('SliderId','=',$request->SliderId)
            ->update([
                'Images' => $file_name,
                'URL' => $request->LinkToContent,
                'Discount' => $request->SaleContent,
                'Content' => $request->EventContent,
                'Active' => $request->SliderActive
            ]);
        return back()->with('edit-success','Cập nhật Slider Thành Công');
    }//action update

    public function delete_slider($id){
        DB::table('slider')->where('SliderID',$id)->delete();
        Return back()->with('delete-success','Xóa thành công');
    }
}

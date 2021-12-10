<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminProductController extends Controller
{
    public function index()
    {
        $product = DB::table('product')->get();
        return view('admin/product/adminproduct', compact('product'));
    }

    //Thêm Sản Phẩm
    public function add()
    {
        $supplier = DB::table('supplier')->select('supplier.SupplierId', 'supplier.SupplierName')->get();
        $product = DB::table('product')->select('product.ProductId', 'product.ProductName')->get();
        return view('admin/product/addproduct', compact('supplier', 'product'));
    }

    public function create(Request $request)
    {
        //        validate request
        $message = [
            'required' => 'Ô này đang bị trống',
            'ProductName.max'=> 'Số kí tự vượt quá cho phép',
            'Discount.max' => 'Chỉ được nhập giá trị từ 0 đến 1',
            'Discount.min' => 'Chỉ được nhập giá trị từ 0 đến 1',
            'Weight.min' => 'Nhập khối lượng lớn hơn 0',
            'Quantity.min' => 'Nhập số lượng lớn hơn hoặc bằng 0',
            'image'=>'Tệp không phải là hình ảnh',
            'mimes'=> 'Hình ảnh không hợp lệ',
            'numeric'=> 'Giá trị truyền vào không phải số',
        ];
        $validate = Validator::make($request->all(), [
            "ProductName" => "required|max:255",
            "Slug" => "required",
            "CategoryId" => "required",
            "SupplierId" => "required",
            "Price" => "required",
            "price_new" => "required",
            "Discount" => "required|numeric|min:0|max:1",
            "Weight" => "required|numeric|min:0",
            "Color" => "required",
            "Quantity" => "required|numeric|min:0",
            "Descreption" => "required",
            "Active" => "required",
            "Images" => "required|image|mimes:jpg,jpeg,svg,png",
//            Còn vướng phần thêm nhiều ảnh
            "images_multiple"=>'required',
            "images_multiple.*"=>'image|mimes:jpg,jpeg,svg,png',
        ],$message);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }
        $check_slug = DB::table('product')->get();
        $check = 0;
        foreach ($check_slug as $slg) {
            if ($slg->Slug == $request->Slug) {
                $check = 1;
                break;
            }
        }
        if ($check != 1) {
            $name_color = '';
            $name_color .= $request->ProductName;
            $name_color .= ' ';
            $name_color .= $request->Color;
//        Up ảnh mặc định lên nà
            $file = $request->Images;
            $file_name = $file->getClientOriginalName();
            $file->move(base_path('public/images/product'), $file_name);

//  Chèn Sản phẩm mới vào danh sách sản phẩm
            DB::table('product')
                ->insert([
                    'ProductName' => $request->ProductName,
                    'Images' => $file_name,
                    'Price' => $request->price_new,
                    'Discount' => $request->Discount,
                    'Slug' => $request->Slug,
                    'Active' => $request->Active,
                    'Weight' => $request->Weight,
                    'Descreption' => $request->Descreption,
                    'CreateAt' => (date('Y-m-d')),
                    'Views' => 0,
                    'SupplierId' => $request->SupplierId,
                    'UserId' => 20,
                    'CategoryId' => $request->CategoryId
                ]);
//        Lấy id sản phẩm vừa tạo ra
            $slug_pd = DB::table('product')->where('Slug', '=', $request->Slug)->select('product.ProductId')->get();
            foreach ($slug_pd as $slug) {
                $ProductId = $slug->ProductId;
            }
//        Chèn tất cả hình ảnh của sản phẩm
            foreach ($request->images_multiple as $img) {
                $file = $img;
                $file_name1 = $file->getClientOriginalName();
                $file->move(base_path('public/images/product'), $file_name1);
                DB::table('product_image')
                    ->insert([
                        'images' => $file_name1,
                        'ProductId' => $ProductId
                    ]);
            }
//        Chèn Biến thể mặc định cho Sản phẩm mới tạo
            DB::table('variant')
                ->insert([
                    'VariantName' => $request->Color,
                    'Price' => 0,
                    'Description' => $name_color,
                    'Active' => 1,
                    'Color' => $file_name,
                    'ProductId' => $ProductId,
                    'Quantity' => $request->Quantity
                ]);
            session()->put('add-success', $request->ProductName);
        } else {
            session()->put('add-success-fail', 'Tên sản phẩm đã tồn tại');
        }
        return redirect()->route('add-product');
    }
    //Sửa Sản Phẩm
    public function edit($slug){
        $supplier = DB::table('supplier')->select('supplier.SupplierId','supplier.SupplierName')->get();
        $product = DB::table('product')->select('product.ProductId','product.ProductName')->get();
        $get_product = DB::table('product')->where('Slug',$slug)->get();
        foreach($get_product as $gd){
            $ProductId = $gd->ProductId;
        }
        $image = DB::table('product_image')->where('ProductId', '=', $ProductId)->get();
        $variant = DB::table('variant')->where('ProductId','=',$ProductId)->get();
        return view('admin/product/editproduct', compact('supplier', 'product', 'get_product', 'image','variant'));
    }
    public function createedit(Request $request)
    {
//        Check trùng tên
        $check=0;
        if($request->Slug!=null){
            $check_name = DB::table('product')->where('ProductName',$request->ProductName)->get();
            foreach($check_name as $item){
                $check++;
            }
        }
//        Xử lí update
        if($check==0){
//            Nếu không chỉnh sửa tên không cần update tên
            if ($request->Slug != null) {
                DB::table('product')->where('ProductId', '=', $request->ProductId)->update([
                    'ProductName' => $request->ProductName,
                    'Slug' => $request->Slug
                ]);
            }
            DB::table('product')->where('ProductId', '=', $request->ProductId)->update([
                'CategoryId' => $request->CategoryId,
                'SupplierId' => $request->SupplierId,
                'Price' => $request->price_new,
                'Discount' => $request->Discount,
                'Weight' => $request->Weight,
                'Descreption' => $request->Descreption,
                'Active' => $request->Active,
            ]);
//            Update Ảnh
            if (isset($request->Images)) {
                $file = $request->Images;
                $file_name = $file->getClientOriginalName();
                $file->move(base_path('public/images/product'), $file_name);

            DB::table('product')->where('ProductId', '=', $request->ProductId)->update([
                'Images' => $file_name
            ]);
        }
//            Check số lượng ảnh và xử lí trả dữ liệu sai về cho admin biết
        $count = DB::table('product_image')->where('ProductId', '=', $request->ProductId)->count();
        $thua = 0;
        $success = 0;
        if (isset($request->images_multiple)) {
            foreach ($request->images_multiple as $img) {
                $count++;
                if ($count <= 8) {
                    $file = $img;
                    $file_name1 = $file->getClientOriginalName();
                    $file->move(base_path('public/images/product'), $file_name1);
                    DB::table('product_image')
                        ->insert([
                            'images' => $file_name1,
                            'ProductId' => $request->ProductId
                        ]);
                    $success++;
                } else {
                    $thua++;
                }
            }
        }
        if ($thua != 0) {
            session()->put('thua', $thua);
            session()->put('duoc', $success);
        }
        session()->put('edit-success', $request->ProductId);}else{
            session()->put('edit-failed','a');
        }
//        Nếu chỉnh sửa tên sản phẩm thành công sẽ trả về route có Slug mới được cập nhật. Trả về trang trước nếu không cập nhật Tên
        if(isset($request->Slug)){
            Return redirect()->route('admin.edit',[$request->Slug]);
        }else{
            Return redirect()->back();
        }

    }
    //Xóa Sản Phẩm
    public function delete_product($slug){
//        Lấy id sản phẩm từ slug
        $ProductId = DB::table('product')->select('ProductId','ProductName')->where('Slug',$slug)->get();
        foreach ($ProductId as $item){
            $id = $item->ProductId;
            $name = $item->ProductName;
        }
//        Xử lí khi xóa sản phẩm sẽ xóa tất cả hình ảnh sản phẩm biến thể sản phẩm liên quan
        DB::table('variant')->where('ProductId',$id)->delete();
        DB::table('product_image')->where('ProductId',$id)->delete();
        DB::table('product')->where('Slug',$slug)->delete();
//      Trả session thông báo thành công
        session()->put('del-success',$name);
        Return redirect()->route('admin.product');
    }

//Danh Mục
    //Thêm Danh Mục
    public function view_category(){
        return view('admin/product/adminCategory');
    }
    public function add_category(){
        return view('admin/product/addcategory');
    }
    public function create_category(Request $request){
//        dd($request->all());
//        exit();
        $message = [
            'unique' => 'Tên đã tồn tại',
            'required' => 'Ô này đang bị trống',
            'image'=>'Tệp không phải là hình ảnh',
            'mimes'=> 'Hình ảnh không hợp lệ',
            'numeric'=> 'Giá trị truyền vào không phải số',
        ];
        $validate = Validator::make($request->all(), [
              "CategoryName" => "required|unique:category",
              "CategorySlug" => "required",
              "CatActive" => "required",
              "CategoryImage" =>"required|image|mimes:jpg,jpeg,svg,png"
        ],$message);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

//        Xử lí ảnh
        $file = $request->CategoryImage;
        $file_name = $file->getClientOriginalName();
        $file->move(base_path('public/images/product'),$file_name);
//      Xử lí thêm danh mục mới
        DB::table('category')
            ->insert([
                'CategoryName'=> $request->CategoryName,
                'CategoryImage'=> $file_name,
                'CatActive'=>$request->CatActive,
                'CategorySlug'=>$request->CategorySlug
            ]);
//      Trả session thông báo thành công
        session()->put('add-success', $request->CategoryName);
        Return redirect()->route('add-category');
    }
    //Sửa Danh Mục
    public function edit_category($slug){
        $category = DB::table('category')->where('CategorySlug', $slug)->get();
        return view('admin/product/editcategory',compact('category'));
    }
    public function createedit_category(Request $request){
//        Xử lí khi update trùng tên sản danh mục khác hoặc danh mục hiện tại
        $check=0;
        if($request->CategoryName != null){
//            Xử lí khi update có update tên
            $check_name = DB::table('category')->where('CategorySlug',$request->CategorySlug)->get();
            foreach($check_name as $item){
                $check++;
            }
//            Nếu không trùng xử lí update danh mục lên DB
            if($check==0){
                DB::table('category')->where('CategoryId',$request->CategoryId)->update([
                   'CategoryName'=>$request->CategoryName,
                   'CategorySlug'=>$request->CategorySlug,
                   'CatActive'=>$request->CatActive
                ]);
//                Nếu tồn tại ảnh thì update ảnh
                if(isset($request->Images)){
                    $file = $request->Images;
                    $file_name = $file->getClientOriginalName();
                    $file->move(base_path('public/images/product'),$file_name);

                    DB::table('category')->where('CategoryId','=',$request->CategoryId)->update([
                        'CategoryImage' => $file_name
                    ]);
                };
            }
        }else{
//            Xử lí khi ko update tên
            if(isset($request->Images)){
                $file = $request->Images;
                $file_name = $file->getClientOriginalName();
                $file->move(base_path('public/images/product'),$file_name);

                DB::table('category')->where('CategoryId','=',$request->CategoryId)->update([
                    'CategoryImage' => $file_name
                ]);
            };
            DB::table('category')->where('CategoryId',$request->CategoryId)->update([
               'CatActive'=>$request->CatActive
            ]);
        }
        if($check==0){
//            Nếu update thành công
            session()->put('e-success',$request->CategoryId);
        }else{
//            Nếu update thất bại
            session()->put('e-failed','a');
        }
//        Return khi có update tên và thêm thành công. Ngược lại sẽ là return về khi thất bại và các trường hợp khác
        if($request->CategorySlug!=null && $check==0){
            Return redirect()->route('edit.category',[$request->CategorySlug]);
        }else{
            return redirect()->back();
        }

    }
    //Xóa Sản Phẩm
    public function delete_category($slug){
//        Xử lí lấy id và tên Danh mục khi có Slug
        $cat_id=DB::table('category')->select('CategoryId','CategoryName')->where('CategorySlug',$slug)->get();
        foreach($cat_id as $cat){
            $id=$cat->CategoryId;
            $name=$cat->CategoryName;
        }
//        Dựa vào id ta lấy được tất cả các id sản phẩm có trong danh mục.
        $pro_id=DB::table('product')->select('ProductId')->where('CategoryId',$id)->get();
//        Xử lí xóa tất cả sản phẩm biến thể sản phẩm hình sản phẩm có liên quan đến danh mục bị xóa trước để ko bị lỗi khóa ngoại
        foreach($pro_id as $pd){
//            Xóa Biến thể và hình ảnh sản phẩm trước
            DB::table('variant')->where('ProductId',$pd->ProductId)->delete();
            DB::table('product_image')->where('ProductId',$pd->ProductId)->delete();
//            Xóa Sản Phẩm tiếp theo
            DB::table('product')->where('ProductId',$pd->ProductId)->delete();
        }
//        Sau đó xử lí xóa danh mục sau cùng
        DB::table('category')->where('CategoryId',$id)->delete();
//        Trả session thông báo thành công
        session()->put('del-success',$name);
        Return redirect()->route('admin.category');
    }

//Biến thể
    //Thêm Biến Thể
    public function create_variant(Request $request){
        $message = [
            'required' => 'Ô này đang bị trống',
            'image'=>'Tệp không phải là hình ảnh',
            'mimes'=> 'Hình ảnh không hợp lệ',
            'numeric'=> 'Giá trị truyền vào không phải số',
        ];
        $validate = Validator::make($request->all(), [
              "ProductId" => "required",
              "Price_variant" => "required|numeric",
              "Color_v" => "required",
              "Quantity_v" => "required|numeric",
              "Description" => "required",
              "Active_v" => "required",
              "Images_v" => "required|image|mimes:jpg,jpeg,svg,png"
        ],$message);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput()->with('page','variant');
        }

        $name = DB::table('product')
            ->where('ProductId','=',$request->ProductId)
            ->select('ProductName')
            ->first();
        $check_name = DB::table('variant')->where('ProductId','=',$request->ProductId)->get();
        $check=0;
        foreach ($check_name as $item){
            if($item->VariantName == $request->Color_v){
                $check = 1;
                break;
            }
        }
        if($check == 0){

//        Update Ảnh biến thể
            $file = $request->Images_v;
            $file_name = $file->getClientOriginalName();
            $file->move(base_path('public/images/product'),$file_name);
//        Lấy tên sản phẩm và màu để thông báo
            $name_color = $name->ProductName;
            $name_color.=' ';
            $name_color.=$request->Color_v;
//            Tiến hành thêm biến thể
            DB::table('variant')
                ->insert([
                    'VariantName'=>$request->Color_v,
                    'Price'=>($request->Price_variant)/100,
                    'Description' =>$request->Description,
                    'Active'=>$request->Active_v,
                    'Color'=>$file_name,
                    'ProductId'=>$request->ProductId,
                    'Quantity'=>$request->Quantity_v
                ]);
//            Trả về session thành công
            session()->put('add-success-v',$name_color);
        }else{
//            Trả về session thất bại khi trùng tên
            session()->put('add-success-f',$request->Color_v);
        }

        Return redirect()->route('add-product');
    }
    //Sửa Biến Thẻ
    public function edit_variant(Request $request){
//      Kiểm tra trùng tên
        $check=0;
        $check_null=0;
        if($request->VariantName!=null){
//            Kiểm tra có trùng tên biến thể khác hay biến thể hiện tại không
            $check_name=DB::table('variant')->where('VariantName',$request->VariantName)->where('ProductId',$request->ProductId)->get();
            foreach($check_name as $item){
                $check++;
            }
        }else{
//            Kiểm tra tên có rỗng hay không
            $check_null++;
        }
//      Nếu không trùng thì tiếp tục
        if($check==0){
//            Nếu không rỗng thì update Tên biến thể
            if($check_null==0) {
                DB::table('variant')->where('VariantId', $request->VariantId)->update([
                    'VariantName' => $request->VariantName
                ]);
            }
//           Update các thông tin khác
            DB::table('variant')->where('VariantId',$request->VariantId)->update([

                'Price'=>$request->Price_variant/100,
                'Description'=>$request->Description,
                'Active'=>$request->Active,
                'Quantity'=>$request->Quantity
            ]);
//            Nếu có hình ảnh thì update hình ảnh mới
            if(isset($request->Images)){
                $file = $request->Images;
                $file_name = $file->getClientOriginalName();
                $file->move(base_path('public/images/product'),$file_name);

                DB::table('variant')->where('VariantId',$request->VariantId)->update([
                    'Color'=>$file_name
                ]);
            }
//            Trả về thông báo khi thành công
            session()->put('add-success-v',$request->VariantId);
        }else{
//            Trả về thông báo lỗi khi thất bại
            session()->put('add-success-f',$request->VariantId);
        }

        Return redirect()->route('admin.edit',[$request->Slug]);
    }
    //Xóa Biến Thể
    public function delete_variant($id){
        DB::table('variant')->where('VariantId',$id)->delete();
        session()->put('del-success-v',$id);
        Return redirect()->back();
    }

    //Load hình ảnh update sản phẩm bằng hàm Ajax
    public function load_img(Request $request)
    {
//        dd($request->All());
        $img = DB::table('product_image')->where('ProductId', $request->productId)->get();
        $output = '<div class="select-img col-12" onclick="getIdimg();">';
        foreach ($img as $i) {
            $output .= '
                <input style="display:none; position: absolute" type="radio" name="emotion" class="input-hidden" id="a' . $i->ImageId . '" value="' . $i->ImageId . '"/>
                <label style="cursor: pointer; position:absolute; top:-5px; color:red;" for="a' . $i->ImageId . '">
                    <i style="font-size: 20px;" class="fab fa-times-circle"></i>
                </label>
                <img style="margin-right:10px; width:10%" title="" src="' . asset('/images/product/' . $i->images) . '"/>
            ';
        }
        $output .= '</div>';
        echo $output;
    }
    //Xóa hình ảnh update sản phẩm bằng Ajax
    public function deleteimg(Request $request)
    {
        DB::table('product_image')->where('ImageId', $request->idimg)->delete();
    }
}

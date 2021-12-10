<?php

namespace App\Http\Controllers;
// use App\Models\HomeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    function index(){
        return view('shop/shop');
    }
    function load_product(Request $request){
        if(!isset($request->cate)||$request->cate==null){
            $data = DB::table('product')
                ->join('category','product.CategoryId','=','category.CategoryId')
                ->select('product.*','category.CatActive','category.CategorySlug')
                ->where('category.CatActive','=',1)
                ->where('product.Price','<',(int)$request->amount)
                ->where('Active','=',1)
                ->where('product.ProductName','like','%'.$request->search.'%')
                ->get();
        }else{
            if(isset($request->search)||isset($request->amount)){
                $data = DB::table('product')
                    ->join('category','product.CategoryId','=','category.CategoryId')
                    ->select('product.*','category.CatActive','category.CategorySlug')
                    ->where('category.CatActive','=',1)
                    ->where('product.Price','<',(int)$request->amount)
                    ->where('Active','=',1)
                    ->where('product.ProductName','like','%'.$request->search.'%')
                    ->where('category.CategorySlug', '=',$request->cate)
                    ->get();
            }else{
                $data = DB::table('product')
                    ->join('category','product.CategoryId','=','category.CategoryId')
                    ->select('product.*','category.CatActive')
                    ->where('category.CatActive','=',1)
                    ->where('Active','=',1)
                    ->get();
            }
        }

        if(!isset($request->page)){
            $request->page = 1;
        }
        $count_pd = count($data);//tong san pham
        $one_page = 9;// san pham 1 trang
        $offset= ($request->page - 1)*$one_page; // lay tu vi tri (neu page = 1 lay offset = 0)
        $total_page =  ceil($count_pd/$one_page);// lam tron so trang
        $prev = $request->page - 1;// lui lai 1 trang
        $next = $request->page + 1;// len 1 trang
        if($count_pd > 9){
            if($request->cate == null){
                $data2 = DB::table('product')
                    ->join('category', 'product.CategoryId', '=', 'category.CategoryId')
                    ->select('product.*', 'category.CatActive', 'category.CategorySlug')
                    ->where('category.CatActive', '=', 1)
                    ->where('Active', '=', 1)
                    ->where('product.Price', '<', (int)$request->amount)
                    ->offset($offset)
                    ->limit($one_page)
                    ->where('product.ProductName', 'like', '%' . $request->search . '%')
                    ->get();
            }else {
                if (isset($request->search) || isset($request->amount)) {
                    $data2 = DB::table('product')
                        ->join('category', 'product.CategoryId', '=', 'category.CategoryId')
                        ->select('product.*', 'category.CatActive', 'category.CategorySlug')
                        ->where('category.CatActive', '=', 1)
                        ->where('Active', '=', 1)
                        ->where('product.Price', '<', (int)$request->amount)
                        ->offset($offset)
                        ->limit($one_page)
                        ->where('product.ProductName', 'like', '%' . $request->search . '%')
                        ->where('category.CategorySlug', '=', $request->cate)
                        ->get();
                } else {
                    $data2 = DB::table('product')
                        ->join('category', 'product.CategoryId', '=', 'category.CategoryId')
                        ->select('product.*', 'category.CatActive')
                        ->where('category.CatActive', '=', 1)
                        ->where('Active', '=', 1)
                        ->offset($offset)
                        ->limit($one_page)
                        ->get();
                }
            }
        }else{
            $data2=$data;
        }
        $output ='<div class="row">';
            if($total_page!=1) {
                $output .= '
            <div style="display: flex; justify-content:center; margin-bottom: 15px;">
            <div style="width: 230px; display:flex; justify-content:center" class="pd_page">';
                if($prev != 0){
                    $output .= '
                        <input type="radio" name="page" class="input-hidden" id="'.$prev.'" value="'.$prev.'"> </input>
                        <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="'.$prev.'"><</label>
                    ';
                }
                for($i=1 ; $i<=$total_page ;$i++ ) {
                    if($i == $request->page){
                        $output .= '<input type="radio" name="page" class="input-hidden" id="'.$i.'" value ="'.$i. '"> </input>
                                <label align="center" style="background-color:#d0011b; font-size:18px; color:white;width:30px; height:30px;  cursor:pointer" for="' .$i.'">'.$i.'</label>
                        ';
                    }else{
                        $output .= '<input type="radio" name="page" class="input-hidden" id="'.$i.'" value ="'.$i. '"> </input>
                                    <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="' .$i.'">'.$i.'</label>
                        ';
                    }
                }
                if($next <= $total_page){
                    $output .='
                <input type="radio" name="page" class="input-hidden" id="'.$next.'" value="'.$next.'"> </input>
                <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="'.$next.'"> > </label>';
                }
                $output .= '
            </div></div>
                ';
            }
                $output .= '';
        foreach ($data2 as $item){
            $output .= '
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-img img-zoom mb-25">
                        <img style="position: absolute; opacity:0.8" src="'.asset('images\icon-img\merry1.png').'" alt="">
                        <a href="'.asset('products/'.$item->Slug).'">
                            <img src="'. asset('images/product/'.$item->Images) .'" alt="">
                        </a>
                        <div class="product-badge badge-top badge-right badge-pink">';
                                if ($item->Discount != 0) {
                                    $output .= '<span style="padding:5px; background-color: #d0011b; color:white; border-radius: 10px;">-'.$item->Discount*100 .'% </span>';
                                }
                        $output .= '</div>
                        <div class="product-action-2-wrap">
                            <a href="/products/'.$item->Slug.'" class="product-action-btn-2" title="Mua Ngay"><i
                                    class="pe-7s-cart"></i> Mua Ngay
                            </a>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="'.asset('products/'.$item->Slug).'">'.$item->ProductName.'</a></h3>
                        <div class="product-price">';
                            if ($item->Discount != 0) {
                                $output .= '<span class="old-price">'.number_format((100*$item->Price)/((1-$item->Discount)*100)).'</span>';
                            }
                            $output .= '<span class="new-price">'.number_format($item->Price).'<sup>đ</sup></span>
                        </div>
                    </div>
                    </div>
                </div>
            ';
        }
        $output .= '</div>';
        if($total_page!=1){
            $output .= '
            <div style="display: flex; justify-content:center; ">
            <div style="width: 230px; display:flex; justify-content:center" class="pd_page">';
                if($prev != 0){
                    $output .= '
                        <input type="radio" name="page" class="input-hidden" id="'.$prev.'" value="'.$prev.'"> </input>
                        <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="'.$prev.'"><</label>
                    ';
                }
                for($i=1 ; $i<=$total_page ;$i++ ) {
                    if($i == $request->page){
                        $output .= '<input type="radio" name="page" class="input-hidden" id="'.$i.'" value ="'.$i. '"> </input>
                                <label align="center" style="background-color:#d0011b; font-size:18px; color:white;width:30px; height:30px;  cursor:pointer" for="' .$i.'">'.$i.'</label>
                        ';
                    }else{
                        $output .= '<input type="radio" name="page" class="input-hidden" id="'.$i.'" value ="'.$i. '"> </input>
                                    <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="' .$i.'">'.$i.'</label>
                        ';
                    }
                }
                if($next <= $total_page){
                $output .='
                <input type="radio" name="page" class="input-hidden" id="'.$next.'" value="'.$next.'"> </input>
                <label align="center" style="font-size:18px;color:#d0011b;border: 1.5px solid #ccc2c2;width:30px; height:30px;  cursor:pointer" for="'.$next.'"> > </label>';
                }
                $output .= '
            </div></div>
        ';
        }
        echo $output;
    }


    function category($slug){
        $data = DB::table('category')->where('category.CategorySlug','=',$slug)->get();
        $check = 0;
        foreach ($data as $item){
            $check++;
        }
        if ($check==0){
            return redirect('/Notfound');
        }
//         dd($data);
        return view('shop/shop',compact('slug'));
    }

}

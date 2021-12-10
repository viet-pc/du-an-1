<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * @throws \JsonException
     */
    function action(Request $request){
        $query = $request->get('keyword');
        $data = DB::table('product')
            ->join('category','product.CategoryId','=','category.CategoryId')
            ->select('product.*','category.CatActive')
            ->where('category.CatActive','=',1)
            ->where('Active','=',1)
            ->Where('ProductName','like','%'.$query.'%')->paginate(9);
//        $data = Product::search($query)->paginate(9);
        $totalRow = $data->count();
            if($request->ajax()){
                $paginate = '';
                $html ='';
                if($totalRow > 0){
                    foreach($data as $item){
                        $html .= '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                                    <div class="product-img img-zoom mb-25">
                                        <a href="'.asset('products/'.$item->Slug).'">
                                            <img src="'.asset('images/product/'.$item->Images) .'" alt="">
                                        </a>
                                        <div class="product-badge badge-top badge-right badge-pink">
                                                ';
                        if($item->Discount !== 0){
                            $html .= '<span>'.$item->Discount*100 .'%</span>';
                        }
                        $html .='
                                        </div>
                                        <div class="product-action-2-wrap">
                                            <button class="product-action-btn-2" title="Add To Cart"><i class="pe-7s-cart"></i> Thêm vào giỏ hàng</button>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="'.asset('products/'.$item->Slug).'">'.$item->ProductName.'</a></h3>
                                        <div class="product-price">';
                        if($item->Discount != 0)
                            $html .= '<span class="old-price">'.number_format((100*$item->Price)/((1-$item->Discount)*100)).'<sup>vnđ</sup></span>';

                        $html .= '<span class="new-price">'.number_format($item->Price).' <sup>vnđ</sup></span>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                    ';

                    }
                    $paginate = '<div  class="paginate" style="">'.
                        $data->appends(request()->input())->links().'</div>';
                    $totalRow = '<span> Kết quả tìm của thừ khóa <span class="text-danger">'.$query.'</span> có <span class="text-danger">'.$totalRow.'</span> sản phẩm </span>';
                }else{
                    $html ='không có sản phẩm bạn tìm';
                }
                $data = array(
                    'totalRow' => $totalRow,
                    'html' => $html,
                    'paginate'=>$paginate
                );
                echo json_encode($data);
            }else{
                return view('shop/shop',compact('data'));
            }
    }
}

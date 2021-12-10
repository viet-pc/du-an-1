<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * @throws \JsonException
     */
    function product(Request $request){
            $product = DB::table('product')
                ->select('CategoryName',
                    'category.CategoryId',
                    DB::raw('COUNT(*) as quantity'),
                    DB::raw('MIN(product.Price) as minPrice'),
                    DB::raw('MAX(product.Price) as maxPrice'),
                    DB::raw('AVG(product.Price) as avgPrice'))
                ->join('category', 'product.CategoryId', '=', 'category.CategoryId')
                ->groupBy('category.CategoryId','CategoryName')
                ->get();
            return json_encode($product, JSON_THROW_ON_ERROR);
    }
    function totalMoney(Request $request,$DaysAgo ,$today){
//        $DaysAgo = date_create($DaysAgo);
//        $today = date_create($today);
//        date_modify($date_create, "-30 days");
//        $DaysAgo = $date_create;
//        $DaysAgo= date_format( $DaysAgo,"Y/m/d");
//        $today = date_format( $today,"Y/m/d");

            $total = DB::table('orders')
                ->where('StatusId', '=','5')
                ->whereBetween('ShipDate',[$DaysAgo, $today ] )
                ->select( DB::raw('SUM(orders.ToPay) as total'),'ShipDate')
                ->groupBy('ShipDate')
                ->get();

            return json_encode($total, JSON_THROW_ON_ERROR);
    }
    function inventory(Request $request){


        $sold = DB::table('orders')
            ->join('orderdetail', 'orderdetail.OrderId', '=', 'orders.OrderId')
            ->join('variant', 'orderdetail.VariantId', '=', 'variant.VariantId')
            ->join('product', 'product.ProductId', '=', 'variant.ProductId')
            ->join('category', 'category.CategoryId', '=', 'product.CategoryId')
            ->select('category.CategoryName', DB::raw('SUM(orderdetail.Quantity) as Quantity'))
            ->where('CatActive', '=', '1')
            ->groupBy('category.CategoryName')
            ->get();
        $stock = DB::table('category')
            ->join('product', 'product.CategoryId', '=', 'category.CategoryId')
            ->join('variant', 'variant.ProductId', '=', 'product.ProductId')
            ->select('CategoryName', DB::raw('SUM(variant.Quantity) as Quantity'))
            ->where('CatActive', '=', '1')
            ->groupBy('category.CategoryName')
            ->get();
        return json_encode([$sold,$stock], JSON_THROW_ON_ERROR);
    }
    function variantSoldStock(Request $request){
                $sold = DB::table('orders')
            ->join('orderdetail','orderdetail.OrderId','=','orders.OrderId')
            ->join('variant','orderdetail.VariantId','=','variant.VariantId')
            ->join('product','product.ProductId','=','variant.ProductId')
            ->join('category','category.CategoryId','=' ,'product.CategoryId')
            ->select('variant.VariantName',DB::raw('SUM(orderdetail.Quantity) as Quantity'))
            ->groupBy('variant.VariantName')
            ->get();
        $stock = DB::table('variant')
            ->where('Quantity' ,'>' ,'0')
            ->select('VariantName','Quantity')
        ->get();
        return json_encode([$sold,$stock], JSON_THROW_ON_ERROR);
    }
}

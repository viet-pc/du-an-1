<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index()
    {
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
        $sold = DB::table('orders')
            ->join('orderdetail', 'orderdetail.OrderId', '=', 'orders.OrderId')
            ->join('variant', 'orderdetail.VariantId', '=', 'variant.VariantId')
            ->join('product', 'product.ProductId', '=', 'variant.ProductId')
            ->join('category', 'category.CategoryId', '=', 'product.CategoryId')
            ->select('variant.VariantName', 'variant.VariantId', DB::raw('SUM(orderdetail.Quantity) as Quantity'))
            ->groupBy('variant.VariantName', 'variant.VariantId')
            ->get();
        $stock = DB::table('variant')
            ->where('Quantity', '>', '0')
            ->select('VariantName','VariantId', 'Quantity')
            ->get();
        $newSold['stock'] = $stock;
        foreach ($stock as $index => $item) {
            for ($i = 1, $iMax = count($sold); $i < $iMax; $i++) {
                if ($item->VariantName === $sold[$i]->VariantName) {
                    $newSold['sold'][$index] = $sold[$i]->Quantity;
                    break;
                } else {
                    $newSold['sold'][$index] = 0;
                }
            }
//            if($sold[$index]){
//                $newSold['sold'][$index] = $sold->$index->Quantity;
//            }else{
//                $newSold['sold'][$index] = 0;
//            }
        }
        return view('admin/dashboard', compact('stock', 'newSold','product'));
    }
}

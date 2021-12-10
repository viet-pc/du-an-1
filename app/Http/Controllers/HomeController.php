<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    function index()
    {
        $data = DB::table('product')
            ->where('Active', '=', 1)
            ->orderByDesc('CreateAt')
            ->limit(8)
            ->get();
        $discount = DB::table('product')
            ->where('Active', '=', 1)
            ->where('Discount', '!=', 0)
            ->orderBy('CreateAt')
            ->limit(8)
            ->get();
        $sliders = DB::table('slider')
            ->where('Active', '=', 1)
            ->get();
        $company = DB::table('supplier')
            ->select('supplier.SupplierName', 'supplier.Images')
            ->get();
        $news = DB::table('blog')
                ->Join('users', 'blog.UserId', 'users.UserId')
                ->join('blog_category', 'blog.Blog_CategoryID', 'blog_category.Blog_CategoryID')
                ->orderByDesc('blog.BlogID')
                ->select('blog.Title', 'Blog_des as desc', 'blog.slug as slug', 'blog.thumbnail', 'blog_category.slug as cateSlug', 'users.Fullname')
                ->limit(3)
                ->get();
        return view('home', compact('data', 'sliders', 'company', 'discount', 'news',));
    }
}

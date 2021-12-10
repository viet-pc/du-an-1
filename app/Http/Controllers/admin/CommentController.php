<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    function index($slug){
        $comments = DB::table('comment')
            ->select('comment.*','product.ProductName','product.Images' ,'users.Fullname')
            ->join('product', 'product.ProductId' , '=' , 'comment.ProductId')
            ->join('users', 'users.UserId' , '=' , 'comment.UserId')
            ->where('product.Slug', '=', $slug)
            ->orderByDesc('comment.CreateAt')
            ->get();
        return view('admin/listCommentInProduct' ,compact('comments'));
    }
    function list(){
        $comments = DB::table('comment')
            ->select('product.Slug','product.ProductName',DB::raw('COUNT(*) as quantity') ,DB::raw('MIN(comment.CreateAt) as minDate'),DB::raw('MAX(comment.CreateAt) as maxDate') )
            ->join('product','product.ProductId', '=','comment.ProductId')
            ->groupBy('comment.ProductId','product.Slug','product.ProductName' )
            ->having('quantity' ,'>', 0)
            ->get();
        return view('admin/listComment',compact('comments'));
    }
    function deleteComment($id,Request $request){
        $delete = DB::table('comment')
            ->where( 'CommentId', '=', $id)->delete();
        if($delete){
            $request->session()->put('status', 'success/Xóa thành công');
        }else{
            $request->session()->put('status', 'danger/Xóa không thành công đã có lỗi xãy ra');
        }
        return back();
    }
}

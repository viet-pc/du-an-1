<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BlogController extends Controller
{
    // Default return
    public function index(){
        $data = DB::table('blog')
                ->join('users', 'users.userId', 'blog.UserId')
                ->join('blog_category', 'blog_category.Blog_CategoryID', 'blog.Blog_CategoryID')
                ->select('blog.Title as title', 'blog.BlogID as id', 'blog.Blog_des as des', 'blog.CreateAt as time', 'blog.view as views', 'blog.slug as slug', 'blog.thumbnail as thumbnail', 'blog.Blog_CategoryID', 'users.Fullname as author', 'blog_category.BlogName as category', 'blog_category.slug as cateSlug')
                ->get();
        $commentData = DB::table('blogcomment')
                        ->join('blog', 'blogcomment.postId','blog.BlogID')
                        ->select('postId', DB::raw('count(*) as count'))
                        ->groupBy('postId')
                        ->get();
        return view('admin.blog.blog', compact('data', 'commentData'));
    }
    public function new(){
        $category = DB::table('blog_category')->select()->get();
        return view('admin.blog.new', compact('category'));
    }
    // Get delete request from client via Ajax
    public function delete(Request $request){
        $id = $request->input('id');
        $rs = [
            "code" => 200,
            "success" => false,
            "msg" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != "" && $id != null){
            DB::table('blogcomment')
                    ->where('postId', $id)
                    ->delete();
            DB::table('blog')
                    ->where('BlogID', $id)
                    ->delete();
            $rs = [
                "code" => 200,
                "success" => true,
                "msg" => "Xoá thành công"
            ];
        }
        return response()->json($rs);
    }

    // Get image upload from client
    public function uploadImage(Request $request){
        $request->validate([
            'upload' => 'required|mimes:png,jpg,jpeg,png|max:2048'
        ]);
        if($request->file()) {
            $image = $request->file('upload');
            $filename = rand().'_'.$this->createSlug($request->file('upload')->getClientOriginalName());
            $image->move('images/blog',$filename);

            return response()->json([
                'success' => true,
                'url' => asset('images/blog').'/'.$filename,
                'fileName' => $filename
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    // Get post entry and save in DB
    public function newPost(Request $request){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình sử lý"
        ];
        $warning = "";
        $content = $request->input('content');
        $title = $request->input('title');
        $thumb = $request->input('thumbnail');
        $categoryId = $request->input('categoryId');
        $slug = $this->createSlug($title).'.'.time();
        $description = $request->input('description');
        if($content == '' || $content == null){
            $warning .= "Không để trống nội dung";
        }
        if($title == '' || $title == null){
            $warning .= "Không để trống tiêu đề";
        }
        if($thumb == '' || $thumb == null){
            $warning .= "Bạn chưa chọn thumbnail";
        }
        if($categoryId == '' || $categoryId == null){
            $warning .= "Bạn chưa chọn danh mục";
        }
        if($description == '' || $description == null){
            $warning .= "Không để trống mô tả";
        }
        if($warning == ""){
            $category = DB::table('blog_category')->where('Blog_CategoryID', $categoryId)->select()->first();
            DB::table('blog')->insert([
                "BlogID" => null,
                "Title" => $title,
                "slug" => $slug,
                "createAt" => date('Y-m-d H:i:s'),
                "Content" => $content,
                "thumbnail" => $thumb,
                "Blog_CategoryID" => $categoryId,
                "UserId" => session('LoggedUser'),
                "view" => 0,
                "Blog_des" => $description
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Successful",
                "content" => $content,
                "title" => $title,
                "thumb" => $thumb,
                "slug" => $slug,
                "redirect" => url('blog')."/".$category->slug."/".$slug
            ];
        }else{
            $rs["messages"] = $warning;
        }
        return response()->json($rs);
    }

    // Return edit view via route
    public function editView($id){
        $data = DB::table('blog')
                ->where('BlogID', $id)
                ->select('blog.Title as title', 'blog.BlogID as id', 'blog.content', 'blog.Blog_des as des', 'blog.CreateAt as time', 'blog.thumbnail as thumbnail', 'blog.Blog_CategoryID')
                ->first();
        $category = DB::table('blog_category')->select()->get();
        return view('admin.blog.editPost', compact('data', 'category'));
    }


    // Action update post data
    public function postUpdate($id, Request $request){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình sử lý"
        ];
        $content = $request->input('content');
        $title = $request->input('title');
        $thumb = $request->input('thumbnail');
        $categoryId = $request->input('categoryId');
        $description = $request->input('description');
        if($content != "" && $title != ""  && $thumb != ""  && $categoryId != ""  && $description != "" ){
            $affected = DB::table('blog')
            ->where('BlogID', $id)
            ->update([
                'Title' => $title,
                'thumbnail' => $thumb,
                'Blog_CategoryID' => $categoryId,
                'Blog_des' => $description,
                'Content' => $content
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Sửa bài thành công"
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" => "Không để trống thông tin"
            ];
        }
        $category = DB::table('blog_category')->select()->get();
        return response()->json($rs);
    }

    // Action active comment
    public function commentActive($id){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != null && $id != ""){
            $affected = DB::table('blogcomment')
            ->where('id', $id)
            ->update([
                'status' => 1
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Duyệt thành công"
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

    // Action deactive comment
    public function commentUnactive($id){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != null && $id != ""){
            $affected = DB::table('blogcomment')
            ->where('id', $id)
            ->update([
                'status' => 0
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Huỷ duyệt thành công"
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

    public function categoryView(){
        $category = DB::table('blog_category')->select()->get();


        return view('admin.blog.category', compact('category'));

    }

    // Action add new category
    public function addNew(Request $request){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        $title = $request->input('title');
        $slug = $this->createSlug($title);
        if($title != "" && $title != null){
            DB::table('blog_category')->insert([
                "Blog_CategoryID" => null,
                "BlogName" => $title,
                "slug" => $slug,
            ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Tạo thành công",
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" => "Không để trống tên danh mục",
            ];
        }
        return response()->json($rs);
    }

    // Action delete category
    public function deleteCategory(Request $request){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        $id = $request->input('id');
        if($id != "" && $id != null){
            DB::table('blog_category')
                ->where('Blog_CategoryID', $id)
                ->delete();
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Xoá thành công",
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" =>"Có lỗi trong quá trình xử lý",
            ];
        }
        return response()->json($rs);
    }

    public function categoryEditView($id){
        $data = DB::table('blog_category')
                ->where('Blog_CategoryID', $id)
                ->select()
                ->first();
        return view('admin.blog.categoryEdit', compact('data'));
    }

    // Action update category
    public function categoryUpdate($id, Request $request){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        $title = $request->input('title');
        if($title != "" && $title != null){
            $slug = $this->createSlug($title);
            DB::table('blog_category')
                ->where('Blog_CategoryID', $id)
                ->update([
                    "BlogName" => $title,
                    "slug" => $slug,
                ]);
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Cập nhật thành công",
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" =>"Bạn chưa nhập tên mới",
            ];
        }
        return response()->json($rs);
    }
    // Get post's comments
    public function categoryCommentList($id){
        $data = DB::table('blogcomment')
                ->join('users', 'users.userId', 'blogcomment.userId')
                ->join('blog','BlogID', 'blogcomment.postId')
                ->where('postId', $id)
                ->select('id', 'users.Fullname','blog.Title','blogcomment.createAt', 'message', 'blogcomment.status')
                ->get();
        return view('admin.blog.commentPostSingle', compact('data'));
    }
    // Action delete comment
    public function commentDelete($id){
        $rs = [
            "success" => false,
            "code" => 200,
            "messages" => "Có lỗi trong quá trình xử lý"
        ];
        if($id != "" && $id != null){
            DB::table('blogcomment')
                ->where('id', $id)
                ->delete();
            $rs = [
                "success" => true,
                "code" => 200,
                "messages" => "Xoá thành công",
            ];
        }else{
            $rs = [
                "success" => false,
                "code" => 200,
                "messages" =>"Có lỗi trong quá trình xử lý",
            ];
        }
        return response()->json($rs);
    }

    // Show deactive comments
    public function commentsView(){
        $data = DB::table('blogcomment')
                ->join('users', 'users.userId', 'blogcomment.userId')
                ->join('blog','BlogID', 'blogcomment.postId')
                ->select('blogcomment.id', 'users.Fullname', 'blog.Title', 'blogcomment.createAt', 'blogcomment.status', 'blogcomment.message',)
                ->where('blogcomment.status', 0)
                ->get();
        return view('admin.blog.comments', compact('data'));
    }



    // Generate string to slug
    public static function createSlug($str){
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/(--|---|----|__|___|___)/', '-', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }
}

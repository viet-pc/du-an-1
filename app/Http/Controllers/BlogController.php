<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class BlogController extends Controller
{
    public $postId;
    function index(){
        $data = DB::table('blog')
            ->Join('users', 'blog.UserId', 'users.UserId')
            ->Join('blog_category', 'blog.Blog_CategoryID','blog_category.Blog_CategoryID')
            ->select('blog_category.*','blog.*','users.Fullname','blog.slug as blogSlug', 'blog_category.slug as categorySlug')
            ->paginate(9);
        return view('blog/blog', compact('data'));
    }
    function viewBySlug($Category, $slug){
        $data = DB::table('blog')->Join('users', 'blog.UserId','users.UserId')
            ->Join('blog_category','blog.Blog_CategoryID', 'blog_category.Blog_CategoryID')
            ->Where('blog.slug',$slug)
            ->Select('blog.*','users.*','blog_category.slug as categorySlug','blog_category.BlogName as BlogName')
            ->first();
        if(isset($data)) {
            $this->postId = $data->BlogID;
            $prePost = $this->getInfoPost($this->postId - 1);
            $nextPost = $this->getInfoPost($this->postId + 1);
            $commentData = $this->getComments($this->postId);
            $sessionView = Session::get('postView_'.$this->postId);
            if (!$sessionView) { 
                Session::put('postView_'.$this->postId, 1);
                DB::table('blog')->where('BlogID', $this->postId)->increment('View');
            }
            return view('blog/postSingle', compact('data','prePost','nextPost','commentData'));
        }else{
            return view('404');
        }
    }
    function viewByCategory($category)
    {
        $data = DB::table('blog_category')
            ->Join('blog', 'blog.Blog_CategoryID','blog_category.Blog_CategoryID')
            ->Join('users', 'blog.UserId','users.UserId')
            ->Where('blog_category.slug',$category)
            ->select('blog_category.*','blog.*','users.Fullname','blog.slug as blogSlug', 'blog_category.slug as categorySlug')
            ->paginate(9);
        $categoryData = DB::table('blog_category')
            ->Where('slug',$category)
            ->first();
        return view('blog/blog',compact('data','categoryData'));
    }
    private function getInfoPost($id){
        return DB::table('blog')->Where('BlogID',$id)
        ->Join('blog_category','blog.Blog_CategoryID','blog_category.Blog_CategoryID')
        ->Select('blog_category.slug as categorySlug','blog.*')
        ->first();
    }
    private function getComments($blogId){
        return DB::table('blogcomment')
        ->Join('users', 'users.UserId', 'blogcomment.userId')
        ->Where([
            ['blogcomment.postId',$blogId],
            ['blogcomment.status', 1]
        ])
        ->Select('users.Fullname as Fullname', 'blogcomment.createAt as createAt', 'message', 'blogcomment.userId', 'blogcomment.id')
        ->paginate(6);
    }

    function insertComment($id, Request $request){
        $message = $request->input('messages');
        $data = [
            'success' => false,
            'message' => 'Có lỗi trong quá trình xử lý',
            'date' => date('Y-m-d H:i:s')
        ];
        if(session('LoggedUser')){
            if($message != '' && $message != null){
                DB::table('blogcomment')->insert([
                    'postId' => $id,
                    'message' => $message,
                    'userId' => session('LoggedUser'),
                    'status' => 1,
                    'createAt' => date('Y-m-d H:i:s')
                ]);
                $data = [
                    'success' => true,
                    'message' => 'Bình luận thành công',
                    'date' => date('Y-m-d H:i:s')
                ];
            }else{
                $data = [
                    'success' => false,
                    'message' => 'Không được để trống dữ liệu',
                    'date' => date('Y-m-d H:i:s')
                ];
            }
        }else{
            $data = [
                'success' => false,
                'message' => 'Không curl được đâu :3',
                'date' => date('Y-m-d H:i:s')
            ];
        }
        return json_encode($data);
    }

    function deleteComment($id, Request $request){
        $data = [
            'success' => false,
            'message' => 'Có lỗi trong quá trình xử lý',
        ];
        if(session('LoggedUser')){
            DB::table('blogcomment')->where('id', $id)->where('userId', session('LoggedUser'))->delete();
            $data = [
                'success' => true,
                'message' => 'Xoá thành công',
            ];
        }else{
            $data['messages'] = 'Có lỗi trong quá trình xử lý';
        }
        return json_encode($data);
    }
}

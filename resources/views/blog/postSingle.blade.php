@extends('layouts.site')
@section('main')
    <div class="blog-details-area pt-100 pb-100">
        <div class="container">
            {{Breadcrumbs::render('post',$data->BlogName, $data->categorySlug, $data->Title, $data->slug)}}
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <div class="blog-details-img-date-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-details-img">
                                <img src="{{asset('/images/blog')}}/{{$data->thumbnail}}" alt="">
                            </div>
                        </div>
                        <div class="blog-meta-2" data-aos="fade-up" data-aos-delay="200">
                            <ul style="display: flex; flex-direction: column">
                                <li style="font-size: small">Ngày đăng: <a>{{$data->CreateAt}}</a></li>
                            </ul>
                        </div>
                        <h1 data-aos="fade-up" data-aos-delay="200">{{$data->Title}}</h1>
                        <p data-aos="fade-up" data-aos-delay="200">{!!$data->Content !!} </p>
                        <div class="tag-social-wrap" style="justify-content: normal">
                            <div style="margin-right: 10px" class="tag-wrap" data-aos="fade-up" data-aos-delay="200">
                                <span>Chia sẻ:</span>
                            </div>
                            <div class="social-comment-digit-wrap" data-aos="fade-up" data-aos-delay="400">
                                <div class="social-icon-style-2">
                                    <a target="_blank" href="https://facebook.com/sharer.php?u={{url()->full()}}""><i
                                        class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="https://twitter.com/intent/tweet?url={{url()->full()}}"><i
                                            class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-author-wrap-2" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-author-img-2">
                                <img src="{{asset('/images/blog/blog-author-2.png')}}" alt="">
                            </div>
                            <div class="blog-author-content-2">
                                <h2>{{$data->Fullname}}</h2>
                                <p>Người viết bài ưu tú.</p>
                                <div class="social-icon-style-3">
                                    <a target="_blank" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                        @if(isset($prePost) && isset($nextPost))
                        <div class="blog-next-previous-post" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-prev-post-wrap">
                                <div class="blog-prev-post-icon">
                                    <a href="{{url('/blog')}}/{{$prePost->categorySlug}}/{{$prePost->slug}}"><i class="fa fa-angle-left"></i></a>
                                </div>
                                <div class="blog-prev-post-content">
                                    <h3><a href="{{url('/blog')}}/{{$prePost->categorySlug}}/{{$prePost->slug}}">{{$prePost->Title}}</a></h3>
                                    <span>{{$prePost->CreateAt}}</span>
                                </div>
                            </div>
                            <div class="blog-next-post-wrap">
                                <div class="blog-next-post-icon">
                                    <a href="{{url('/blog')}}/{{$nextPost->categorySlug}}/{{$nextPost->slug}}"> <i class="fa fa-angle-right"></i> </a>
                                </div>
                                <div class="blog-next-post-content">
                                    <h3><a href="{{url('/blog')}}/{{$nextPost->categorySlug}}/{{$nextPost->slug}}">{{$nextPost->Title}}</a></h3>
                                    <span>{{$nextPost->CreateAt}}</span>
                                </div>
                            </div>
                        </div>
                        @elseif(isset($prePost) || isset($nextPost))
                            @if(isset($prePost))
                                <div class="blog-next-previous-post" data-aos="fade-up" data-aos-delay="200">
                                    <div class="blog-prev-post-wrap">
                                        <div class="blog-prev-post-icon">
                                            <a href="{{url('/blog')}}/{{$prePost->categorySlug}}/{{$prePost->slug}}"><i class="fa fa-angle-left"></i></a>
                                        </div>
                                        <div class="blog-prev-post-content">
                                            <h3><a href="{{url('/blog')}}/{{$prePost->categorySlug}}/{{$prePost->slug}}">{{$prePost->Title}}</a></h3>
                                            <span>{{$prePost->CreateAt}}</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif(isset($nextPost))
                                <div class="blog-next-previous-post" data-aos="fade-up" data-aos-delay="200">
                                    <div class="blog-next-post-wrap">
                                        <div class="blog-next-post-icon">
                                            <a href="{{url('/blog')}}/{{$nextPost->categorySlug}}/{{$nextPost->slug}}"> <i class="fa fa-angle-right"></i> </a>
                                        </div>
                                        <div class="blog-next-post-content">
                                            <h3><a href="{{url('/blog')}}/{{$nextPost->categorySlug}}/{{$nextPost->slug}}">{{$nextPost->Title}}</a></h3>
                                            <span>{{$nextPost->CreateAt}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="blog-comment-wrapper">
                            <h4 class="blog-dec-title aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">Bình luận ({{count($commentData)}})</h4>
                            @if(count($commentData) >= 1)
                                @foreach($commentData as $comment)
                                <div class="single-comment-wrapper single-comment-border aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                    <div class="blog-comment-img">
                                        <img src="assets/images/blog/blog-comment-1.png" alt="">
                                    </div>
                                    <div class="blog-comment-content">
                                        <div class="comment-info-reply-wrap">
                                            <div class="comment-info">
                                                <span>{{$comment->createAt}}</span>
                                                <h4>{{$comment->Fullname}}</h4>
                                            </div>
                                            @if(session('LoggedUser') == $comment->userId)
                                            <div class="comment-reply">
                                                <a value="{{$comment->id}}" onclick="deleteComment(this)">Xoá bình luận</a>
                                            </div>
                                            @endif
                                        </div>
                                        <p>{{$comment->message}}</p>
                                        <div class="comment-reply">
                                            <a href="#">Reply</a>
                                        </div>
                                    </div>
                                </div>


                                @endforeach
                                <center>
                                    {!! $commentData->links() !!}
                                </center>
                            @else
                                <center>Chưa có bình luận nào ở đây<center>
                            @endif
                        </div>
                        @if(session()->has('LoggedUser'))
                        <div id="commentBox" class="blog-comment-form-wrap">
                            <div class="blog-comment-form-title">
                                <h2 data-aos="fade-up" data-aos-delay="200">Để lại bình luận</h2>
                                <p data-aos="fade-up" data-aos-delay="400">Hãy để lại bình luận nếu như bạn có đóng góp hoặc ý kiến nhé</p>
                            </div>
                            <div class="blog-comment-form">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="single-blog-comment-form" data-aos="fade-up" data-aos-delay="500">
                                                <textarea id="messages" placeholder="Nhập bình luận của bạn ở đây"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="comment-submit-btn btn-hover" data-aos="fade-up" data-aos-delay="700">
                                                <button id="submit" class="submit">Gửi bình luận <i class=" ti-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <center>Bạn cần <a href="{{url('buyer/login')}}" target="_blank">đăng nhập</a> để có thể bình luận</center>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4" style="min-height: 100vh">
                    <div class="sidebar-wrapper blog-sidebar-mt">
                        <div class="sidebar-widget mb-50 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-author-content text-center sticky">
                                <a href="blog-details.html"><img src="{{asset('/images/blog/blog-author.png')}}" alt=""></a>
                                <h2>{{$data->Fullname}}</h2>
                                <h4>Content</h4>
                                <div class="social-icon-style-1">
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-dribbble"></i></a>
                                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-glide-g"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


@stop()
@section('scripts')
<script type="text/javascript">
    
    $(document).ready(function() {
        $('#submit').click(function(e) {
            Notiflix.Block.Pulse('#commentBox');
            e.preventDefault();
            $.ajax({
                url: "{{url('api/comment')}}/{{$data->BlogID}}/insert",
                type: 'POST',
                data: {
                    messages: $('#messages').val(),
                    _token: "{{csrf_token()}}"
                }
            }).done(function(res) {
                Notiflix.Block.Remove('#commentBox');
                var data = $.parseJSON(res);
                if(data.success == true){
                    Notiflix.Notify.Success(data.message);
                    setTimeout(function () {
                        location.reload(true);
                    }, 3000);
                }else{
                    Notiflix.Notify.Warning(data.message);
                }
            });
        });
    });
</script>
<script>
    function deleteComment(a){
        Notiflix.Confirm.Show(
        'Bạn muốn xoá bình luận này?',
        'Việc này sẽ không thể khôi phục',
        'Xoá',
        'Huỷ',
        function okCb(){
            id = $(a).attr('value');
            $.ajax({
                    url: "{{url('api/comment')}}/"+id+"/delete",
                    type: 'POST',
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                }).done(function(res) {
                    var data = $.parseJSON(res);
                    if(data.success == true){
                        Notiflix.Notify.Success(data.message);
                        $(a).parent().parent().parent().parent().remove();
                    }else{
                        Notiflix.Notify.Warning(data.message);
                    }
                })
            }
        );
    }
</script>
@stop()

@extends('layouts.site')
@section('main')
    <div class="blog-details-area pt-100 pb-100">
        <div class="container">
            {{Breadcrumbs::render('post',$data->BlogName, $data->categorySlug, $data->Title, $data->slug)}}
            <div class="row" style="justify-content: center">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <div class="blog-details-img-date-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-details-img">
                                <img src="{{asset('/images/blog/blog-details.png')}}" alt="">
                            </div>
                        </div>
                        <div class="blog-meta-2" data-aos="fade-up" data-aos-delay="200">
                            <ul style="display: flex; flex-direction: column">
                                <li style="font-size: small">Ngày đăng: <a>{{$data->CreateAt}}</a></li>
                            </ul>
                        </div>
                        <h1 data-aos="fade-up" data-aos-delay="200">{{$data->Title}}</h1>
                        <div style="width: 100%" data-aos="fade-up" data-aos-delay="200">
                            {!! $data->Content !!}
                        </div>
                        <div class="tag-social-wrap" style="justify-content: normal">
                            <div style="margin-right: 10px" class="tag-wrap" data-aos="fade-up" data-aos-delay="200">
                                <span>Chia sẻ:</span>
                            </div>
                            <div class="social-comment-digit-wrap" data-aos="fade-up" data-aos-delay="400">
                                <div class="social-icon-style-2">
                                    <a target="_blank" href="https://facebook.com/sharer.php?u={{url()->full()}}""><i
                                        class="fa fa-facebook"></i></a>
                                    <a target="_blank" href="https://twitter.com/intent/tweet?url={{url()->full()}}"><i
                                            class="fa fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="blog-author-wrap-2" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-author-img-2">
                                <img src="{{asset('/images/blog/blog-author-2.png')}}" alt="">
                            </div>
                            <div class="blog-author-content-2">
                                <h2>{{$data->Fullname}}</h2>
                                <p>Lorem ipsum dolor sit amet, consecteg adipisicing elit sed do eius tempor incididunt
                                    ut lab et dolore magna aliqua. Ut enim ad minikl veniam, quis nostrud
                                    exercitatio.</p>
                                <div class="social-icon-style-3">
                                    <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                    <a target="_blank" href="#"><i class="fa fa-instagram"></i></a>
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
                            <h4 class="blog-dec-title aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">Comments (02)</h4>
                            <div class="single-comment-wrapper single-comment-border aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                <div class="blog-comment-img">
                                    <img src="assets/images/blog/blog-comment-1.png" alt="">
                                </div>
                                <div class="blog-comment-content">
                                    <div class="comment-info-reply-wrap">
                                        <div class="comment-info">
                                            <span>October 14, 2020 </span>
                                            <h4>Anthony Stephens</h4>
                                        </div>
                                        <div class="comment-reply">
                                            <a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consecteg adipisicing elit sed do eius tempor incididunt ut lab et dolore magna aliqua. Ut enim ad minikl veniam, quis nostrud exercitatio. </p>
                                </div>
                            </div>
                            <div class="single-comment-wrapper single-comment-ml aos-init aos-animate" data-aos="fade-up" data-aos-delay="600">
                                <div class="blog-comment-img">
                                    <img src="assets/images/blog/blog-comment-2.png" alt="">
                                </div>
                                <div class="blog-comment-content">
                                    <div class="comment-info-reply-wrap">
                                        <div class="comment-info">
                                            <span>October 14, 2020 </span>
                                            <h4>DX Joxova</h4>
                                        </div>
                                        <div class="comment-reply">
                                            <a href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodl tempor incididunt ut labore et dolore </p>
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

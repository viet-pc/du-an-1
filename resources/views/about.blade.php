@extends('layouts.site')
@section('main')
    <div class="blog-details-area pt-100 pb-100">
        <div class="container">
            {{ Breadcrumbs::render('about') }}
            <div class="row" style="justify-content: center">
                <div class="col-lg-8">
                    <div class="blog-details-wrapper">
                        <p data-aos="fade-up" data-aos-delay="200">{!!$data->content!!}</p>
                        <div class="tag-social-wrap" style="justify-content: normal">
                            <div style="margin-right: 10px" class="tag-wrap" data-aos="fade-up" data-aos-delay="200">
                                <span>Chia sẻ:</span>
                            </div>
                            <div class="social-comment-digit-wrap" data-aos="fade-up" data-aos-delay="400">
                                <div class="social-icon-style-2">
                                    <a target="_blank" href="https://facebook.com/sharer.php?u={{url()->full()}}"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="https://twitter.com/intent/tweet?url={{url()->full()}}"><i class="fab fa-twitter"></i></a>
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

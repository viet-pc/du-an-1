@extends('layouts.site')
@section('main')
    {{--    slider--}}
    <div class="slider-area">
        <div class="slider-active swiper-container">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide">
                        <div
                            class="intro-section slider-height-1 slider-content-center bg-img single-animation-wrap slider-bg-color-2"
                            style="background-image:url({{asset('./images/slider/'.$slider->Images)}});">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 hm2-slider-animation">
                                        <div class="slider-content-2 slider-content-2-wrap slider-animated-2">
                                            <h3 class="animated">{{$slider->Discount}}</h3>
                                            <h1 class="animated" style="text-transform: uppercase;">{{$slider->Content}}</h1>
                                            <div class="slider-btn-2 btn-hover">
                                                <a href="{{$slider->URL}}" class="btn hover-border-radius theme-color animated">
                                                    Xem ngay
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="home-slider-prev2 main-slider-nav2"><i class="fa fa-angle-left"></i></div>
                <div class="home-slider-next2 main-slider-nav2"><i class="fa fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    {{--    Danh mục--}}
    <div class="category-area bg-gray-4 pt-95 pb-100">
        <div class="container">
            <div class="section-title-2 st-border-center text-center mb-75" data-aos="fade-up" data-aos-delay="200">
                <h2>Danh mục sản phẩm</h2>
            </div>
            <div class="category-slider-active-2 swiper-container">
                <div class="swiper-wrapper">
                    @foreach($category as $cat)
                        <div class="cat-container">
                            <div class="cat-img">
                                <center>
                                    <a href="category/{{$cat->CategorySlug}}">
                                        <img class="cat-normal-img"
                                             src="{{asset('images/product/'.$cat->CategoryImage)}}" alt="">
                                    </a>
                                </center>
                            </div>
                            <div class="cat-name">
                                <h4><a href="category/{{$cat->CategorySlug}}">{{$cat->CategoryName}}</a></h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Sản Phẩm   --}}
    <div class="product-area pb-60 pt-30">
        <div class="container">
            {{-- NAV Sản Phẩm--}}
            <div class="section-title-tab-wrap mb-75">
                <div class="section-title-2" data-aos="fade-up" data-aos-delay="200">
                    <h2>Sản Phẩm Nổi Bật</h2>
                </div>
                <div class="tab-style-1 nav" data-aos="fade-up" data-aos-delay="400">
                    <a class="active" href="#pro-1" data-bs-toggle="tab">Sản phẩm mới </a>
                    <a href="#pro-2" data-bs-toggle="tab" class=""> Bán chạy </a>
                    <a href="#pro-3" data-bs-toggle="tab" class=""> Giảm giá </a>
                </div>
            </div>

            <div class="tab-content jump">
                {{-- Sản Phẩm Mới--}}
                <div id="pro-1" class="tab-pane active">
                    <div class="row">
                        @foreach($data as $item)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                                    <div class="product-img img-zoom mb-25">
                                        <img style="position: absolute; opacity:0.8"
                                             src="{{asset('images\icon-img\merry1.png')}}" alt="">
                                        <a href="products/{{$item->Slug}}">
                                            <img src="{{asset('images/product/'.$item->Images)}}" alt="">
                                        </a>
                                        <div class="product-badge badge-top badge-right badge-pink">
                                            @if ($item->Discount != 0)
                                                <span
                                                    style="padding:5px; background-color: #d0011b; color:white; border-radius: 10px;">-{{$item->Discount*100}}%</span>
                                            @endif
                                        </div>
                                        <div class="product-action-2-wrap">
                                            <a href="/products/{{$item->Slug}}" class="product-action-btn-2"
                                               title="Mua Ngay"><i
                                                    class="pe-7s-cart"></i> Mua Ngay
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a id="{{$item->ProductId}}" slug="{{$item->Slug}}"
                                               href="products/{{$item->Slug}}">{{$item->ProductName}}</a></h3>
                                        <div class="product-price">
                                            @if ($item->Discount != 0)
                                                <span class="old-price">{{number_format((100*$item->Price)/((1-$item->Discount)*100))}}</span>
                                            @endif
                                            <span
                                                class="new-price">{{number_format($item->Price)}} <sup>đ</sup></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Sản Phẩm Bán chạy--}}
                <div id="pro-2" class="tab-pane">
                    <div class="row">
                        @foreach($data as $item)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                                    <div class="product-img img-zoom mb-25">
                                        <img style="position: absolute; opacity:0.8"
                                             src="{{asset('images\icon-img\merry1.png')}}" alt="">
                                        <a href="products/{{$item->Slug}}">
                                            <img src="{{asset('images/product/'.$item->Images)}}" alt="">
                                        </a>
                                        <div class="product-badge badge-top badge-right badge-pink">
                                            @if ($item->Discount != 0)
                                                <span
                                                    style="padding:5px; background-color: #d0011b; color:white; border-radius: 10px;">-{{$item->Discount*100}}%</span>
                                            @endif
                                        </div>
                                        <div class="product-action-2-wrap">
                                            <a href="/products/{{$item->Slug}}" class="product-action-btn-2"
                                               title="Mua Ngay"><i
                                                    class="pe-7s-cart"></i> Mua Ngay
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a id="{{$item->ProductId}}" slug="{{$item->Slug}}"
                                               href="products/{{$item->Slug}}">{{$item->ProductName}}</a></h3>
                                        <div class="product-price">
                                            @if ($item->Discount != 0)
                                                <span class="old-price">{{number_format((100*$item->Price)/((1-$item->Discount)*100))}} <sup>vnđ</sup></span>
                                            @endif
                                            <span
                                                class="new-price">{{number_format($item->Price)}} <sup>vnđ</sup></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Sản Phẩm Giảm Giá--}}
                <div id="pro-3" class="tab-pane">
                    <div class="row">
                        @foreach($discount as $item)
                            @if($item->Discount !=0)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                                        <div class="product-img img-zoom mb-25">
                                            <img style="position: absolute; opacity:0.8"
                                                 src="{{asset('images\icon-img\merry1.png')}}" alt="">
                                            <a href="products/{{$item->Slug}}">
                                                <img src="{{asset('images/product/'.$item->Images)}}" alt="">
                                            </a>
                                            <div class="product-badge badge-top badge-right badge-pink">
                                                <span
                                                    style="padding:5px; background-color: #d0011b; color:white; border-radius: 10px;">-{{$item->Discount*100}}%</span>
                                            </div>
                                            <div class="product-action-2-wrap">
                                                <a href="/products/{{$item->Slug}}" class="product-action-btn-2"
                                                   title="Mua Ngay"><i
                                                        class="pe-7s-cart"></i> Mua Ngay
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a id="{{$item->ProductId}}" slug="{{$item->Slug}}"
                                                   href="products/{{$item->Slug}}">{{$item->ProductName}}</a></h3>
                                            <div class="product-price">
                                                @if ($item->Discount != 0)
                                                    <span class="old-price">{{number_format((100*$item->Price)/((1-$item->Discount)*100))}} <sup>vnđ</sup></span>
                                                @endif
                                                <span
                                                    class="new-price">{{number_format($item->Price)}} <sup>vnđ</sup></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="brand-logo-area pb-95">
        <div class="container">
            <div class="section-title-2" data-aos="fade-up" data-aos-delay="200" style="margin-bottom: 40px">
                <h2>Nhà Phân Phối</h2>
            </div>
            <div class="brand-logo-active swiper-container">
                <div class="swiper-wrapper">
                    @foreach($company as $com)
                        <div class="swiper-slide">
                            <div class="single-brand-logo" data-aos="fade-up" data-aos-delay="200">
                                <a style="cursor: pointer;"><img src="{{asset('images/supplier/'.$com->Images)}}"
                                                                 alt=""></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="blog-area pb-70">
        <div class="container">
            <div class="section-title-2" data-aos="fade-up" data-aos-delay="200" style="margin-bottom: 40px">
                <h2>Tin tức</h2>
            </div>
            <div class="row">
                @foreach($news as $new)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-wrap mb-30" data-aos="fade-up" data-aos-delay="200">
                        <div class="blog-img-date-wrap mb-25">
                            <div class="blog-img">
                                <a href="{{url('/blog')}}/{{$new->cateSlug}}/{{$new->slug}}"><img src="{{asset('images/blog')}}/{{$new->thumbnail}}" alt="{{$new->slug}}"></a>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <ul>
                                    <li>Đăng bởi: <a>{{$new->Fullname}}</a></li>
                                </ul>
                            </div>
                            <h3><a href="{{url('/blog')}}/{{$new->cateSlug}}/{{$new->slug}}">{{Str::limit($new->Title),'10','(...)'}}</a></h3>
                            <p>{{Str::limit($new->desc),'150','(...)'}}</p>
                            <div class="blog-btn-2 btn-hover">
                                <a class="btn hover-border-radius theme-color" href="{{url('/blog')}}/{{$new->cateSlug}}/{{$new->slug}}">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>

    </script>
@stop()

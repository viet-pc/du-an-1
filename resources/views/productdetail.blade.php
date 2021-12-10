@extends('layouts.head')
@section('main')

<div class="product-details-area pb-100 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-details-img-wrap product-details-vertical-wrap" data-aos="fade-up" data-aos-delay="200">
                    <div class="product-details-small-img-wrap">
                        <div class="swiper-container product-details-small-img-slider-1 pd-small-img-style">
                            <div class="swiper-wrapper">
                                {{-- Hiển thị hình ảnh sản phẩm--}}
                                @foreach($data as $images)
                                <div class="swiper-slide">
                                    <div class="product-details-small-img">
                                        <img src="{{asset('images/product/'.$images->images)}}" alt="Product Thumnail">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pd-prev pd-nav-style"> <i class="ti-angle-up"></i></div>
                        <div class="pd-next pd-nav-style"> <i class="ti-angle-down"></i></div>
                    </div>
                    <div class="swiper-container product-details-big-img-slider-1 pd-big-img-style">
                        <div class="swiper-wrapper">
                            {{-- Hiển thị hình ảnh trung tâm--}}
                            @foreach($data as $images)
                            <div class="swiper-slide">
                                <div class="easyzoom-style">
                                    <img src="{{asset('images/product/'.$images->images)}}" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-details-content" data-aos="fade-up" data-aos-delay="400">
                    {{-- Tên Chi tiết sản phẩm--}}
                    <h2>{{$data[0]->ProductName}}</h2>
                    {{-- Giá sản phẩm--}}
                    <div class="product-details-price">
                        {{-- Nếu ko có giảm giá thì không cần in giá cũ--}}
                        @if($data[0]->Discount != 0)
                        <span class="old-price">{{number_format((100*$data[0]->Price)/((1-$data[0]->Discount)*100))}} <sup>vnđ</sup></span>
                        @endif
                        {{-- Giá mới--}}
                        <span class="new-price">{{number_format($data[0]->Price)}} <sup>vnđ</sup></span>
                    </div>
                    {{-- Đánh giá sản phẩm theo sao--}}
                    <div class="product-details-review">
                        <div class="product-rating">
                            <i class=" ti-star"></i>
                            <i class=" ti-star"></i>
                            <i class=" ti-star"></i>
                            <i class=" ti-star"></i>
                            <i class=" ti-star"></i>
                        </div>
                        <span>( 1 Khách hàng đánh giá )</span>
                    </div>
                    {{-- Biến thể màu của sản phẩm--}}
                    <div class="product-color product-color-active product-details-color">
                        <span>Màu :</span>
                        <ul>
                            @foreach($variant as $color)
                            <li><a class='pd_img_color' href="#"><img src="images/product/{{$color->Color}}" alt=""></a></li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- Thêm Sản Phẩm vào giỏ hàng --}}
                    <div class="product-details-action-wrap">
                        <div class="product-quality">
                            <input class="cart-plus-minus-box input-text qty text" name="qtybutton" value="1">
                        </div>
                        <div class="single-product-cart btn-hover">
                            <a href="#">Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                    {{-- Danh mục của Sản Phẩm--}}
                    <div class="product-details-meta">
                        <ul>
                            <li><span class="title">Danh mục:</span>
                                <ul>
                                    <li><a href="#">{{$data[0]->CategoryName}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop()

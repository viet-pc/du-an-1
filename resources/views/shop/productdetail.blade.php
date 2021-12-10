@extends('layouts.site')
@section('main')
{{--{{Breadcrumbs::render('products', $data[0]->ProductName, $data[0]->Slug)}}--}}

<div class="product-details-area pb-100 pt-30">
    <div class="container">
        {{Breadcrumbs::render('products',$data[0]->CategoryName, $data[0]->CategorySlug, $data[0]->ProductName, $data[0]->Slug)}}
        <div class="row">
            <div style="" class="col-lg-6">
                <div style="height:520px" class="product-details-img-wrap product-details-vertical-wrap" data-aos="fade-up" data-aos-delay="200">
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
                                    <img style="position: absolute; width:30%; bottom:0; right:0;" src="{{asset('images\icon-img\merry2.png')}}" alt="">
                                    <img src="{{asset('images/product/'.$images->images)}}" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div style="padding-left:10px; padding-right:30px;" class="col-lg-6">
                <div class="product-details-content" data-aos="fade-up" data-aos-delay="400">
                    {{-- Tên Chi tiết sản phẩm--}}
                    <input class='price' type="hidden" value="{{number_format((100*$data[0]->Price)/((1-$data[0]->Discount)*100))}}">
                    <h2 class="pt-15 pl-10">{{$data[0]->ProductName}}
                    </h2>
                    {{-- Đánh giá sản phẩm theo sao--}}
                    <div class="product-details-review pl-10 pt-15">
                        <h3>{{round($star,1)}}/ <h4>5</h4></h3>
                        <div class="product-rating">
                            <i style="color:#d0011b" class="fas fa-star"></i>
                        </div>
                        @if(count($comment)==0)
                            <span>( Chưa có khách hàng đánh giá )</span>
                        @else
                            <span>( {{count($comment)}} Khách hàng đánh giá )</span>
                        @endif
                    </div>
                    {{-- Giá sản phẩm--}}
                    @foreach($variant as $color)
                        @if(!isset($check))
                            <div class="product-details-price quantity-view" id="a{{$color->VariantId}}">
                            {{-- Giá mới--}}
                                <span class="new-price">{{number_format($data[0]->Price + $data[0]->Price * $color->Price)}}<sup>đ</sup></span> <br>
                            {{-- Nếu ko có giảm giá thì không cần in giá cũ--}}
                                @if($data[0]->Discount != 0)
                                    <span class="old-price">{{number_format((100*$data[0]->Price + $data[0]->Price * $color->Price)/((1-$data[0]->Discount)*100))}}<sup>đ</sup> </span>
                                    <span class="dis-c">-{{$data[0]->Discount*100}}%</span>
                                @endif
                            </div>
                            @php $check=0; @endphp
                        @else
                            <div style="display: none" class="product-details-price quantity-view" id="a{{$color->VariantId}}">
                                {{-- Giá mới--}}
                                <span class="new-price">{{number_format($data[0]->Price + $data[0]->Price * $color->Price)}}<sup>đ</sup></span> <br>
                                {{-- Nếu ko có giảm giá thì không cần in giá cũ--}}
                                @if($data[0]->Discount != 0)
                                    <span class="old-price">{{number_format((100*$data[0]->Price + $data[0]->Price * $color->Price)/((1-$data[0]->Discount)*100))}}<sup>đ</sup> </span>
                                    <span class="dis-c">-{{$data[0]->Discount*100}}%</span>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    {{-- Biến thể màu của sản phẩm--}}
                    <div class="product-color product-color-active product-details-color pl-10">
                        <span class="title">Màu :</span>
                        <ul>
                            <div class='pd_img_color'>
                                @foreach($variant as $color)
                                    <input class="price_var" type="hidden" value="{{$color->Price}}">
                                    <input type="radio" name="emotion" id="{{$color->VariantId}}" data-id="{{$color->VariantId}}" class="input-hidden" value="{{$color->VariantId}}"/>
                                    <label class="mr-5" for="{{$color->VariantId}}">
                                        <img title="{{$color->VariantName}}" src="{{asset('./images/product/'.$color->Color)}}" alt="{{$color->VariantName}}"/>
                                    </label>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                    <div class="product-color product-color-active product-details-color pl-10">
                        <span class="title">Khối lượng : {{$data[0]->Weight}} Kg</span>
                    </div>

                        <div class="pl-10 product-color product-color-active product-details-color active" >
                            @foreach($variant as $color)
                                <span style="display: none" class='quantity-view' id="b{{$color->VariantId}}" class="title">
                                    Số lượng còn lại: @if($color->Quantity!=0) <span style="color:#d0011b; font-weight: bold">{{$color->Quantity}} (Sản phẩm)</span> @else <span style="color:red; font-weight: bold">Sản phẩm này dã hết hàng</span> @endif
                                </span>
                            @endforeach
                        </div>

                    {{-- Thêm Sản Phẩm vào giỏ hàng --}}
                    <div class="product-details-action-wrap pl-10 pt-15">
                        <div class="product-quality">
                            <input class="cart-plus-minus-box input-text qty text quantity-add-cart" name="qtybutton" value="1">
                        </div>

                        <div class="single-product-cart btn-hover pl-10">
                            @if (Session::has('LoggedUser'))
                                <a style="cursor: pointer;" slug="{{$data[0]->Slug}}" onclick="AddToCart('{{$data[0]->Slug}}')" name="AddCart" class="product-action-btn-2">Thêm vào giỏ hàng</a>
                            @else
                                <a href="/buyer/login" class="product-action-btn-2">Thêm vào giỏ hàng</a>
                            @endif
                        </div>
                    </div>
                    {{-- Danh mục của Sản Phẩm--}}
                    <div class="product-details-meta pl-10">
                        <ul>
                            <li><span class="title">Danh mục:</span>
                                <ul>
                                    <li><a href="{{asset('/category/'.$data[0]->CategorySlug)}}">{{$data[0]->CategoryName}}</a></li>
                                </ul>
                            </li>
                            <li><span class="title">Nhà phân phối:</span>
                                <ul>
                                    <li><a href="">{{$data[0]->SupplierName}}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
{{--            Bình luận--}}
            <div style='padding-top:50px'class="description-review-area pb-85">
                <div class="container">
                    <div class="description-review-topbar nav" data-aos="fade-up" data-aos-delay="200">
                        <a data-bs-toggle="tab" href="#des-details1" class=""> MÔ TẢ SẢN PHẨM </a>
                        <a data-bs-toggle="tab" href="#des-details3" class=""> BÌNH LUẬN </a>
                    </div>
                    <div class="tab-content">
                        <div id="des-details1" class="tab-pane active">
                            <div class="product-description-content text-center">
                                <h2>{{$data[0]->ProductName}}</h2>
                                <p>{{$data[0]->Descreption}} </p>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                                <form>
                                    @csrf
                                    <input type="hidden" name="comment_productId" class="comment_productId" value="{{$data[0]->ProductId}}">
                                    <div id="comment_show">
                                    </div>
                                </form>
                            @if($accept == true)
                            <div class="ratting-form-wrapper">
                                <h3>Thêm đánh giá và bình luận của bạn</h3>
                                <p>Hãy thêm đánh giá và bình luận của bạn về sản phẩm nào >.<</p>
                                <div class="ratting-form">
                                    <img style="width:50px;" src="{{asset('./images/users/default.jpg')}}" alt=""> {{session()->get('LoggedUserName')}}
                                    <form>
                                    @csrf
{{--                                        <input type="hidden" name="comment_productId" class="comment_productId" value="{{$data[0]->ProductId}}">--}}
                                        <input type="hidden" name="comment_userId" class="comment_userId" value="{{session()->get('LoggedUser')}}">
                                        <input type="hidden" name="comment_createAt" class="comment_createAt" value="{{date('Y-m-d')}}">
                                        <div class="your-rating-wrap">
                                            <span>Đánh giá:<span style="color:red">*</span></span>
                                                <fieldset class="starability-basic">
                                                    <input type="radio" id="rate1" name="rating" value="1"/>
                                                    <label for="rate1" title="Kinh khủng">1 star</label>

                                                    <input type="radio" id="rate2" name="rating" value="2"/>
                                                    <label for="rate2" title="Không tốt">2 stars</label>

                                                    <input type="radio" id="rate3" name="rating" value="3"/>
                                                    <label for="rate3" title="Tốt">3 stars</label>

                                                    <input type="radio" id="rate4" name="rating" value="4"/>
                                                    <label for="rate4" title="Quá Tốt">4 stars</label>

                                                    <input type="radio" id="rate5" name="rating" value="5" checked/>
                                                    <label for="rate5" title="Tuyệt vời">5 stars</label>
                                                </fieldset>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="rating-form-style mb-15">
                                                    <span style="font-size:16px">Bình luận của bạn: <span style="color:red">*</span></span>
                                                    <textarea class="comment_content" name="comment_content"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-submit">
                                                    <input type="button" class="send-comment" value="Gửi bình luận">
                                                </div>
                                            </div>
                                            <div id="notify_comment"></div>
                                        </div>
                                    </form>
                                </div>
                                @else
                                <div>
                                    <p>Bạn chưa đăng nhập. Bạn có muốn đăng nhập để bình luận? <a href="{{asset('/buyer/login')}}">Đăng nhập</a></p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="related-product-area pb-95">
                <div class="container">
                    <div class="section-title-2 st-border-center text-center mb-75" data-aos="fade-up" data-aos-delay="200">
                        <h2>Sản Phẩm Liên Quan</h2>
                    </div>
                    <div class="related-product-active swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($relative as $item)
                            <div class="swiper-slide">
                                <div class="product-wrap" data-aos="fade-up" data-aos-delay="200">
                                    <div class="product-img img-zoom mb-25">
                                        <img style="position: absolute; opacity:0.8" src="{{asset('images\icon-img\merry1.png')}}" alt="">
                                        <a href="{{asset('products/'.$item->Slug)}}">
                                            <img src="{{ asset('images/product/'.$item->Images) }}" alt="">
                                        </a>
                                        <div class="product-badge badge-top badge-right badge-pink">
                                            @if ($item->Discount != 0)
                                                <span style="padding:5px; background-color: #d0011b; color:white; border-radius: 10px;">-{{$item->Discount*100}}%</span>
                                            @endif
                                        </div>
                                        <div class="product-action-2-wrap">
                                            <a href="/products/{{$item->Slug}}" class="product-action-btn-2" title="Mua Ngay"><i
                                                    class="pe-7s-cart"></i> Mua Ngay
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{asset('products/'.$item->Slug)}}">{{$item->ProductName}}</a></h3>
                                        <div class="product-price">
                                            <span class="old-price">{{number_format((100*$item->Price)/((1-$item->Discount)*100))}}</span>
                                            <span class="new-price">{{number_format($item->Price)}} <sup>đ</sup> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
        let check = 0;
        $(document).ready(function(){
            load_comment();

            function load_comment() {
                var productId = $('.comment_productId').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url("/load-comment")}}",
                    method:"POST",
                    data:{
                        productId:productId,
                        _token:_token
                    },
                    success:function(data){
                        $('#comment_show').html(data);
                    }
                });
            }

            $(document).on('click', '.delete-cmt', function() {
                var r = confirm("Bạn có chắc xóa bình luận này không?")
                if(r == true){
                    let id_comment = $(this).find('input').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{url("/del-comment")}}",
                        method:"POST",
                        data:{
                            id_comment:id_comment,
                            _token:_token
                        },
                        success:function(data){
                            load_comment();
                            alert('Đã xóa bình luận');
                        }
                    });
                }


            })

            $('.send-comment').click(function (){
                var productId = $('.comment_productId').val();
                var userId = $('.comment_userId').val();
                var commentCreateAt = $('.comment_createAt').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();

                var checkbox = document.getElementsByName("rating");
                for (var i = 0; i < checkbox.length; i++){
                    if (checkbox[i].checked === true){
                        var rating = checkbox[i].value;
                    }
                }

                $.ajax({
                    url:"{{url("/send-comment")}}",
                    method:"POST",
                    data:{
                        productId:productId,
                        userId:userId,
                        comment_content:comment_content,
                        commentCreateAt:commentCreateAt,
                        rating:rating,
                        _token:_token
                    },
                    success:function(data){
                        $('#notify_comment').html('<p class="text text-success"> Thêm bình luận thành công</p>');
                        load_comment();
                    }
                });
            });
        });
        $('.pd_img_color').click(function(){
            let variantId = $('input[name="emotion"]:checked').val();
            if( check != variantId){
                let tab = $('.quantity-view');
                for (i = 0; i < tab.length; i++) {
                    tab[i].style.display = "none";
                }
                let change = 'a'+variantId;
                let change2 = 'b'+variantId;
                document.getElementById(change).style.display = 'block';
                document.getElementById(change2).style.display = 'block';
                check = variantId;
            }
        });
    </script>
@stop()

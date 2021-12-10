@extends('layouts.site')
@section('main')
{{--Style cho pagination--}}
<style>
    .pagination{
        justify-content: center;
    }
    .page-item.active .page-link {
        background-color: #d0011b;
        border-color: #d0011b;
    }
    .page-link {
        color: black;
    }
    .page-link:hover {
        color: #d0011b;
    }
    .pagination a:focus {
        color: black;
        box-shadow: 0 0 5px #d0011b;
    }
    .row{
        animation: fadeEffect 1.5s;
    }
    @keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    input[type=radio]:checked + label>p {
        padding:5px;
        background-color: #d0011b;
        color:white;
        font-size: 14px;
        border-radius:15px;
        margin:5px;
    }
    input[type=radio] + label>p {
        padding:5px;
        background-color: white;
        color:#d0011b;
        font-size: 14px;
        border-radius:15px;
        margin:5px;
        border:1px solid #d0011b;
    }

    #amount option{
        font-size:16px;
        padding:0;
        margin:0;
    }

    .price-slider-amount .label-input{
        flex-wrap: wrap;
    }
</style>
<div class="banner">
    <img style="width:100%;" src="{{asset('./images/banner/banner_shop.jpg')}}" alt="">
</div>

<div class="shop-area shop-page-responsive pb-100">
    <div class="container">
        <hr>
        {{--{{ Breadcrumbs::render('shop') }}--}}
        @if(isset($data[0]->CategoryName))
            {{Breadcrumbs::render('productCategory',$data[0]->CategoryName, $data[0]->CategorySlug)}}
        @else
            {{Breadcrumbs::render('shop')}}
        @endif
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-bottom-area">
                    <div class="tab-content jump">
                        <form action="">
                            @csrf
                        <div id="shop-1" class="tab-pane active load-product">
{{--                            Hiển thị sản phẩm ở đây--}}
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <hr>
                <div class="sidebar-wrapper">
                    <div class="sidebar-widget" data-aos="fade-up" data-aos-delay="200">
                        <div class="search-wrap-2">
{{--                            <form class="search-2-form">--}}
                            <div class="sidebar-widget-title">
                                <h3>Tìm kiếm theo tên</h3>
                            </div>
                            <div class="search-2-form" style="margin-top:20px">
                                <input placeholder="Tìm kiếm sản phẩm*" id="search-all" type="text">
                            </div>
{{--                            </form>--}}
                        </div>
                    </div>
                    <div class="sidebar-widget sidebar-widget-border mb-40 pb-35" data-aos="fade-up" data-aos-delay="200">
                        <hr>
                        <div class="sidebar-widget-title">
                            <h3>Tìm kiếm theo giá</h3>
                        </div>
                        <div class="price-filter">
                            <div class="price-slider-amount">
                                <div class="label-input">
                                    <label for="amount" ></label>
                                    <select size="7" style="color:#d0011b; margin-left: 10px; overflow:hidden" name="price" id="amount">
                                        <option value="1000000">Dưới 1,000,000</option>
                                        <option value="2000000">Dưới 2,000,000</option>
                                        <option value="5000000">Dưới 5,000,000</option>
                                        <option value="10000000">Dưới 10,000,000</option>
                                        <option value="15000000">Dưới 15,000,000</option>
                                        <option value="20000000">Dưới 20,000,000</option>
                                        <option value="100000000" selected="selected">Dưới 100,000,000</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-widget sidebar-widget-border mb-40 pb-35" data-aos="fade-up" data-aos-delay="200">
                        <div class="sidebar-widget-title mb-25">
                            <h3>Danh Mục Sản Phẩm</h3>
                        </div>
                        <div class="sidebar-list-style">
                            <div id="search_cat" style="display: block;">
                                <input class="input-hidden" type="radio" name="cate" id="novalue" no value>
                                <label class="cate" for="novalue"><p>⛔ Không</p></label>
                                @foreach($category as $cat)
                                    @if(isset($slug))
                                        @if($cat->CategorySlug == $slug)
                                            <input class="input-hidden" type="radio" name="cate" id="{{$cat->CategoryName}}" checked value="{{$cat->CategorySlug}}">
                                            <label class="cate" for="{{$cat->CategoryName}}"><p >{{$cat->CategoryName}}</p></label>
                                        @else
                                            <input class="input-hidden" type="radio" name="cate" id="{{$cat->CategoryName}}" value="{{$cat->CategorySlug}}">
                                            <label class="cate" for="{{$cat->CategoryName}}"><p >{{$cat->CategoryName}}</p></label>
                                        @endif
                                    @else
                                        <input class="input-hidden" type="radio" name="cate" id="{{$cat->CategoryName}}" value="{{$cat->CategorySlug}}">
                                        <label class="cate" for="{{$cat->CategoryName}}"><p >{{$cat->CategoryName}}</p></label>
                                    @endif
                                @endforeach
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
        $(document).ready(function(){
            load_product();

            function load_product() {
                let cate = $('input[name="cate"]:checked').val();
                let amount = $('#amount').val();
                if(amount == null){
                    amount = 100000000;
                }
                let search = $('#search-all').val();
                let page = $('input[name="page"]:checked').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:`{{url("/shop/load-product")}}`,
                    method:"POST",
                    data:{
                        cate:cate,
                        amount:amount,
                        search:search,
                        page:page,
                        _token:_token
                    },
                    success:function(data){
                        $('.load-product').html(data);
                    }
                })
            }

            $(document).on('click', '.pd_page', function() {
                load_product();
            })

            $('#search-all').change(function(){
                let cate = $('input[name="cate"]:checked').val();
                let amount = $('#amount').val();
                if(amount == null){
                    amount = 100000000;
                }
                let search = $(this).val()
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:`{{url("/shop/load-product")}}`,
                    method:"POST",
                    data:{
                        cate:cate,
                        amount:amount,
                        search:search,
                        _token:_token
                    },
                    success:function(data){
                        $('.load-product').html(data);
                    }
                })
            })

            $('#amount').change(function(){
                let cate = $('input[name="cate"]:checked').val();
                let search = $('#search-all').val();
                let amount = $(this).val()
                if(amount == null){
                    amount = 100000000;
                }
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:`{{url("/shop/load-product")}}`,
                    method:"POST",
                    data:{
                        cate:cate,
                        amount:amount,
                        search:search,
                        _token:_token
                    },
                    success:function(data){
                        $('.load-product').html(data);
                    }
                })
            })
            $('#search_cat').click(function (){
                let cate = $('input[name="cate"]:checked').val();
                let search = $('#search-all').val();
                let amount = $('#amount').val();
                if(amount == null){
                    amount = 100000000;
                }
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:`{{url("/shop/load-product")}}`,
                    method:"POST",
                    data:{
                        cate:cate,
                        amount:amount,
                        search:search,
                        _token:_token
                    },
                    success:function(data){
                        $('.load-product').html(data);
                    }
                })
            })
        });
    </script>
@stop()


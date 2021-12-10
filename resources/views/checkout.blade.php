@extends('layouts.site')
@section('main')

    <!-- Load the `goong-geocoder` plugin. -->
    <script src="https://cdn.jsdelivr.net/npm/@goongmaps/goong-geocoder/dist/goong-geocoder.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@goongmaps/goong-geocoder/dist/goong-geocoder.css" rel="stylesheet"
          type="text/css"/>

    <!-- Promise polyfill script is  -->
    <!-- to use Goong Geocoder in IE 11. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
    <style>
        #geocoder {
            z-index: 1;
            width: 100%;
        }

        .goongjs-ctrl-geocoder {
            min-width: 100%;
        }

        .mapboxgl-ctrl-geocoder--icon-search {
            display: none;
        }

        @media screen and (min-width: 640px) {
            .mapboxgl-ctrl-geocoder {
                max-width: 100%;
                width: 100%;
            }
        }

        .mapboxgl-ctrl-geocoder {
            box-shadow: none;
        }

    </style>
    {{--                                            @if (Session::has('Cart') != null)--}}

    <div class="checkout-main-area pb-100">
        <div class="container">
            {{ Breadcrumbs::render('checkout') }}
            <div class="checkout-wrap pt-30">
                <form method="post" id="checkout-form" action="{{route('checkout.submit')}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-7 billing-block">
                            <div class="billing-info-wrap">
                                <h3>Thông Tin Thanh Toán</h3>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Họ & Tên <abbr class=""
                                                                  title="Thông tin bắt buộc">*</abbr></label>
                                            <input id="Fullname" type="text" placeholder="Nhập họ và tên người nhận"
                                                   name="Fullname"
                                                   value="{{old('Fullname')}}" required>
                                            <small id="Fullname-validation"
                                                   class="text-danger"> @error('Fullname') {{$message}} @enderror</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="billing-info mb-20">
                                            <label>Địa chỉ <abbr class=""
                                                                 title="Thông tin bắt buộc">*</abbr></label>
                                            {{--Company address--}}
                                            <input id="latt" type="number" name="latt" value="10.854252599999999"
                                                   hidden>
                                            <input id="long" type="text" name="long" value="106.62872511153768" hidden>

                                            {{--autocomplete & place info--}}
                                            <div id="geocoder" class="billing-address"></div>
                                            <p id="kilo"></p>
                                            <input type="hidden" name="kilometers" id="check_location">
                                            <small id="resultkilo"
                                                   class="text-danger">@error('kilometers') {{$message}} @enderror </small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info mb-20">
                                            <label>SĐT <abbr class=""
                                                             title="Thông tin bắt buộc">*</abbr></label>
                                            <input id="Phone" type="text" placeholder="Nhập số điện thoại người nhận"
                                                   name="Phone" value="{{old('Phone')}}" required>
                                            <small id="Phone-validation" class="text-danger"> @error('Phone'){{$message}} @enderror
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info mb-20">
                                            <label for="Email">Email <abbr class=""
                                                                           title="Thông tin bắt buộc">*</abbr></label>
                                            <input id="Email" type="email" placeholder="Email người nhận" name="Email"
                                                   value="{{old('Email')}}" required>
                                            <small id="Email-validation"
                                                   class="text-danger">@error('Email') {{$message}} @enderror</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="checkout-account-toggle open-toggle2 mb-30">
                                    <label>Xác nhận tạo đơn <abbr class=""
                                                                  title="Thông tin bắt buộc">*</abbr></label>
                                    <input placeholder="Nhập mật khẩu tài khoản tạo đơn" type="password"
                                           autocomplete="off" name="Password" required>
                                    @error('Password') <small id="" class="text-danger">{{$message}}</small> @enderror
                                </div>
                                <div class="additional-info-wrap">
                                    <label>Ghi chú</label>
                                    <textarea class="note" placeholder="Yêu cầu đặc biệt, lưu ý cho Cửa Hàng/Shipper"
                                              name="Message">{{old('Message')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="your-order-area">
                                <h3>Đơn hàng của bạn</h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li>Sản phẩm <span>Tổng</span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <ul>
                                                @foreach(Session::get('Cart')->products as $value)
                                                    <li>
                                                        {{$value['productInfo']->VariantName}} X {{$value['quantity']}}
                                                        <span>{{number_format($value['price'])}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li>Tổng tiền hóa đơn
                                                    <span>{{number_format(Session::get('Cart')->totalPrice)}}</span>
                                                </li>
                                                <input id="total-before-shipfee" type="number"
                                                       value="{{Session::get('Cart')->totalPrice}}" hidden>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="payment-method">
                                        @error('Payment_method') <span id="" class="text-danger"
                                                                       style="border: 2px solid red; padding:4px;line-height:50px">{{$message}}</span> @enderror
                                        <div class="pay-top sin-payment">
                                            <input id="payment-method-3" class="input-radio" type="radio" value="1"
                                                   name="Payment_method" required>
                                            <label for="payment-method-3">Thanh toán khi nhận hàng</label>
                                            <div class="payment-box" id="after">
                                                <p>Quãng đường vận chuyển: <span id="shipping-km"
                                                                                 class="payment-detail">0</span></p>
                                                <p>Phạm vi xác định: <span id="city_check"
                                                                           class="payment-detail"></span>
                                                    <input type="number" id="thecity" value="" hidden>
                                                </p>
                                                <p>Phí vận chuyển: <span id="shipfee-km" class="payment-detail">?</span>
                                                    vnd/km</p>
                                                <p class="text-warning">Tối đa 500.000vnđ tiền vận chuyển tuyến
                                                    Nam-Bắc</p>
                                                <p>Tổng tiền ship: <span id="totalship-fee"
                                                                         class="payment-detail">0</span> vnd</p>
                                                <input id="totalship" name="totalshipfee" value="" hidden>
                                                <hr>
                                                <p>Hàng sẽ được giao trong vòng 48h(3-5 ngày đối với giao hàng ở tỉnh),
                                                    quý
                                                    khách vui lòng giữ điện thoại trong thời gian này.</p>
                                            </div>
                                        </div>
                                        <div class="pay-top sin-payment sin-payment-3">
                                            <span class="text-warning"> Đang bảo trì thanh toán trả trước ⚠</span>
                                            <input id="payment-method-4" class="input-radio" type="radio" value="2"
                                                   name="Payment_method" disabled required>
                                            <label for="payment-method-4">
                                                <img alt="" src="{{asset('images/paypal.png')}}">
                                                Thanh toán trả trước
                                            </label>
                                            <div class="payment-box" id="before">
                                                <p>Giảm <span style="color:#d0011b">80%</span> tiền ship(tối đa 150k)
                                                    đối với thanh toán trả trước.</p>
                                            </div>
                                        </div>
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li>Tổng số tiền phải thanh toán <span
                                                        id="total-order">{{number_format((Session::get('Cart')->totalPrice) + $shipfee)}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p align="justify" style="font-size: 13px; margin-top: 8px">Nhấn
                                    <span style="color:#d0011b">"ĐẶT HÀNG"</span>
                                    đồng nghĩa với việc bạn đồng ý với
                                    <a href="#" class="rules">Điều khoản MetaH</a>
                                </p>
                                <div class="Place-order btn-hover">
                                    <button type="submit">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

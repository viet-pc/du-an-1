@extends('layouts.site')
@section('main')

<div class="my-account-wrapper pb-100 pt-100"">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a href="#info" {{$page === 'info' ? 'class=active':''}}  data-bs-toggle="tab">Thông tin tài khoản</a>
{{--                                <a href="#dashboad" data-bs-toggle="tab">DashboardController</a>--}}
                                <a href="#password_change" {{$page === 'change_pass' ? 'class=active':''}} data-bs-toggle="tab" >Đổi mật khẩu</a>
                                <a href="#orders" {{$page === 'orders' ? 'class="active"':''}} data-bs-toggle="tab">Lịch sử đơn hàng</a>

{{--                                <a href="#payment-method" {{$page === 'payment-method' ? 'class="active"':''}} data-bs-toggle="tab">Payment Method</a>--}}
{{--                                <a href="#address-edit" {{$page === 'address-edit' ? 'class="active"':''}} data-bs-toggle="tab">Address</a>--}}

                                <a href="{{route('buyer.logout')}}">Đăng xuất</a>
                            </div>
                        </div>

                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
{{--                                <div class="tab-pane fade show active" id="dashboad" role="tabpanel">--}}
{{--                                    <div class="myaccount-content">--}}
{{--                                        <h3>DashboardController</h3>--}}
{{--                                        <div class="welcome">--}}
{{--                                            <p>Hello, <strong>Alex Tuntuni</strong> (If Not <strong>Tuntuni !</strong><a href="login-register.html" class="logout"> Logout</a>)</p>--}}
{{--                                        </div>--}}

{{--                                        <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Lịch sử đơn hàng</h3>
                                        @if (isset($orders[0]))
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Ngày Mua Hàng</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Tổng Tiền</th>
                                                        <th>Thao Tác</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach($orders as $item)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td>{{$item->CreateAt}}</td>
                                                            @if ($item->StatusId == 1 || $item->StatusId == 5)
                                                                <td style="color: #d0011b;">{{$item->StatusName}}</td>
                                                            @elseif ($item->StatusId == 4)
                                                                <td style="color: #1bc88c;">{{$item->StatusName}}</td>
                                                            @else
                                                                <td style="color: orange;">{{$item->StatusName}}</td>
                                                            @endif
                                                            <td>{{number_format($item->ToPay)}} VNĐ</td>
                                                            <td><a href="" class="check-btn sqr-btn btn-orderdetail" data-id="{{$item->OrderId}}">Chi tiết</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p style="align:center">Bạn hiện chưa có đơn hàng nào đã đặt!</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="password_change" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Đổi Mật khẩu</h3>
                                        <div class="account-details-form">
{{--                                            @if(Session::get('status'))--}}
{{--                                                <div class="alert alert-success">--}}
{{--                                                    {{Session::get('status')}}--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
                                            <form action="{{route('buyer.change')}}" method="post">
                                                @csrf
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Mật khẩu hiện tại
                                                        <input type="password" id="password_current" name="password-current" placeholder="Nhập Mật khẩu hiện tại của bạn"/>
                                                        <span class="text-danger">@error('password-current') {{$message}} @enderror</span>
                                                    </label>
                                                </div>

                                                <div class="single-input-item">
                                                    <label for="email" class="required">Mật khẩu mới
                                                        <input type="password" id="password_new" name="password-new" placeholder="nhập mật khẩu mới"/>
                                                        <span class="text-danger">@error('password-new') {{$message}} @enderror</span>
                                                    </label>
                                                </div>
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Xác nhậ mật khẩu
                                                        <input type="password" id="password_confirm" name="password_confirmation" placeholder="Nhập lại mật khẩu mới" />
                                                        <span class="text-danger">@error('password_confirmation') {{$message}} @enderror</span>
                                                    </label>
                                                </div>
                                                <div class="single-input-item btn-hover">
                                                    <button class="check-btn sqr-btn">Đổi mật khẩu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
{{--                                <div class="tab-pane fade" id="payment-method" role="tabpanel">--}}
{{--                                    <div class="myaccount-content">--}}
{{--                                        <h3>Payment Method</h3>--}}
{{--                                        <p class="saved-message">You Can't Saved Your Payment Method yet.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
{{--                                <div class="tab-pane fade" id="address-edit" role="tabpanel">--}}
{{--                                    <div class="myaccount-content">--}}
{{--                                        <h3>Billing Address</h3>--}}
{{--                                        <address>--}}
{{--                                            <p><strong>Alex Tuntuni</strong></p>--}}
{{--                                            <p>1355 Market St, Suite 900 <br>--}}
{{--                                                San Francisco, CA 94103</p>--}}
{{--                                            <p>Mobile: (123) 456-7890</p>--}}
{{--                                        </address>--}}
{{--                                        <a href="#" class="check-btn sqr-btn "><i class="fa fa-edit"></i> Edit Address</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Thông Tin Tài Khoản</h3>
                                        <div class="account-details-form">
                                            <form action="{{route('buyer.update')}}" method="post">

                                                @csrf
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Họ va Tên
                                                        <input type="text" id="ho_ten" name="name" value="{{$user->Fullname ??old('name')}}" placeholder="Nhập họ và tên của bạn"/>
                                                        <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                                                    </label>
                                                </div>

                                                <div class="single-input-item">
                                                    <label for="email" class="required">Địa Chỉ Email
                                                    <input type="email" id="email" name="email" value="{{$user->Email ?? old('email')}}"  placeholder="Nhập email của bạn"/></label>
                                                    <span class="text-danger" >@error('email') {{$message}}@enderror</span>
                                                </div>
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Số Diện Thoại
                                                    <input type="text" id="phone " name="phone" value="{{$user->Phone ?? old('phone')}}"  placeholder="Nhập số điện thoại của bạn" /></label>
                                                    <span class="text-danger" >@error('phone') {{$message}}@enderror</span>
                                                </div>
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Địa Chỉ
                                                    <input type="text" id="address" name="address" value="{{$user->Address??old('address')}}"  placeholder="Nhập địa chỉ hiện tại của bạn để thận tiện cho việc giao hàng"/></label>
                                                    <span class="text-danger" >@error('address') {{$message}}@enderror</span>
                                                </div>
                                                <div class="single-input-item">
                                                    <label for="display-name" class="required">Mật khẩu
                                                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu của bạn"/></label>
                                                    <span class="text-danger" >@error('password') {{$message}}@enderror</span>
                                                </div>
                                                <div class="single-input-item btn-hover">
                                                    <button class="check-btn sqr-btn">Lưu thay đổi</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div> <!-- Single Tab Content End -->
                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
    <div class="modals" id="modals"></div>
</div>
    <script>

        $('.alertdemo').on('click', function(e){

            e.preventDefault();

            theme = "blue";



            $.jAlert({

                'title': 'jAlert Demo',

                'content': 'This is a simple jAlert that is based at jQuery!',

                'theme': theme,

                'backgroundColor': 'white',

                'btns': [

                    {'text':'OK', 'theme':theme}

                ]

            });

        });

        // Ajax hiển thị OrderDetail
        $('.btn-orderdetail').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/profile/order-detail/'+$(this).data('id'),
                method: 'GET',
                success:function(data){
                    $('#modals').html(data);
                    $('.modal__overlay').on('click', function() {
                        $('#modals').empty();
                    });
                }
            });
        });

    </script>
@stop()

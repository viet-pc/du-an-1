@extends('layouts.site')
@section('main')
    <div class="login-register-area pb-100 pt-95">
        <div class="container">
            <div id="{{$page}}"></div>
            {{ Breadcrumbs::render('buyer',$page) }}
            <div class="row">
                <div class="col-lg-8 col-md-12 offset-lg-2">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a  data-bs-toggle="tab" href="#lg1">
                                <h4> Đăng Nhập </h4>
                            </a>
                            <a data-bs-toggle="tab" href="#lg2">
                                <h4> Đăng Ký </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div class="results">
                                @if(Session::get('status'))
                                    <div class="alert alert-success">
                                        {{Session::get('status')}}
                                    </div>
                                @endif
                            </div>
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('buyer.check')}}" id="form-login" method="post">
                                            @csrf
                                            <input type="email" name="loginEmail" placeholder="Email"
                                                   value="{{ old('email') }}">
                                            <span class="text-danger error-login-email">@error('loginEmail') {{$message}}@enderror</span>
                                            <input type="password" name="loginPassword" placeholder="Mật khẩu">

                                            <span class="text-danger error-login-password">@error('loginPassword') {{$message}}@enderror</span>
                                            <div class="login-toggle-btn">
{{--                                                <label>--}}
{{--                                                    <input type="checkbox">--}}
{{--                                                </label>--}}
{{--                                                <label>Nhớ đăng nhâp</label>--}}
                                                <a href="#lg3" >Quên mật khẩu?</a>
                                            </div>
                                            <div class="button-box btn-hover" >
                                                <button type="submit" class="button text-white" style="width:100%">Đăng nhập</button>
                                                <div class="line d-flex justify-content-around align-items-center">
                                                    <div class="hr"></div>
                                                    <div><span class="text">HOẶC</span></div>
                                                    <div class="hr"></div>
                                                </div>
                                                <a   class="btn button face-login" href="{{route('facebook.google')}}" ><i class="fab fa-facebook"></i>
                                                    Facebook</a>
                                                <a href="{{route('login.google')}}" class="btn button google-login" ><svg width="18" height="19" viewBox="0 0 18 19" xmlns="http://www.w3.org/2000/svg"><path d="M9 7.84363V11.307H13.8438C13.6365 12.428 12.9994 13.373 12.0489 14.0064V16.2534H14.9562C16.6601 14.6951 17.641 12.4029 17.641 9.67839C17.641 9.04502 17.5854 8.43176 17.4792 7.84865H9V7.84363Z" fill="#3E82F1"></path><path d="M9.00001 14.861C6.65394 14.861 4.67192 13.2876 3.96406 11.1714H0.955627V13.4937C2.43709 16.4142 5.48091 18.4198 9.00001 18.4198C11.432 18.4198 13.4697 17.6206 14.9562 16.2533L12.0489 14.0064C11.245 14.5443 10.2135 14.861 9.00001 14.861Z" fill="#32A753"></path><path d="M3.96404 5.45605H0.955617C0.348876 6.66246 0 8.02972 0 9.47238C0 10.915 0.348876 12.2823 0.955617 13.4887L3.96404 11.1714C3.78202 10.6335 3.6809 10.0605 3.6809 9.47238C3.6809 8.88426 3.78202 8.31122 3.96404 7.77336V5.45605Z" fill="#F9BB00"></path><path d="M0.955627 5.45597L3.96406 7.77327C4.67192 5.65703 6.65394 4.08368 9.00001 4.08368C10.3197 4.08368 11.5079 4.53608 12.4382 5.42078L15.0219 2.85214C13.4646 1.40948 11.427 0.52478 9.00001 0.52478C5.48091 0.52478 2.43709 2.53043 0.955627 5.45597Z" fill="#E74133"></path></svg></i>
                                                    Google </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{ route('buyer.insertUser') }}" id="form-register" method="post">
                                            @csrf
                                            <input type="text" name="name" placeholder="Họ và Tên"
                                                   value="{{old('name')}}">
                                            <span class="text-danger">@error('name'){{$message}} @enderror</span>
                                            <input type="email" name="email" placeholder="Email"
                                                   value="{{old('email')}}">
                                            <span class="text-danger">@error('email'){{$message}} @enderror</span>
                                            <input type="password" name="password" id="password-register" placeholder="Mật Khẩu">
                                            <span class="text-danger">@error('password'){{$message}} @enderror</span>
                                            <input type="password" name="password_confirmation" placeholder="Xác thực mật Khẩu">
                                            <span class="text-danger">@error('password'){{$message}} @enderror</span>
                                            <div class="button-box btn-hover">
                                                <button type="submit">Đăng ký</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="lg3" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form action="{{route('buyer.postEmail')}}" id="post-email-forget" method="post">
                                            @csrf
                                            <input type="email" name="email" placeholder="Nhâp email đã đăng ký"
                                                   value="{{old('email')}}">
                                            <span class="text-danger" id="err-email-forget">@error('email'){{$message}} @enderror</span>
                                            <div class="button-box btn-hover">
                                                <button type="submit">Gửi lại mật khẩu</button>
                                            </div>
                                        </form>
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
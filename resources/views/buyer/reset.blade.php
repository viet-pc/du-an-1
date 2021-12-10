@extends('layouts.site')
@section('main')
    <div class="login-register-area pb-100 pt-95">
        <div class="container">
{{--            <div id="{{$page}}"></div>--}}
            <div class="row">
                <div class="col-lg-8 col-md-12 offset-lg-2">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a  data-bs-toggle="tab" href="#lg1">
                                <h4> Đặt lại mật khẩu </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div class="results">
                                @if(Session::get('status'))
                                    <div class="alert alert-success">
                                        {{Session::get('status')}}
                                    </div>
                                @endif
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="{{route('buyer.resetToken')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="token" value="{{$token}}">
                                                <input type="email" name="email" placeholder="Email"
                                                       value="{{ $email ?? old('email') }}">
                                                <span class="text-danger">@error('email') {{$message}}@enderror</span>
                                                <input type="password" name="password" placeholder="Mật khẩu">

                                                <span class="text-danger">@error('password') {{$message}}@enderror</span>
                                                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">

                                                <span class="text-danger">@error('password_confirmation') {{$message}}@enderror</span>
                                                <div class="button-box btn-hover">
                                                    <button type="submit">Đăng nhập</button>
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

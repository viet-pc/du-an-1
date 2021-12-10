@extends('layouts.site')
@section('main')
    <style>
        .hehe{
            margin-top:30px;
            display: flex;
        }
        .left{
            font-size:20px;
            padding-top:10%;
            width: 40%;
            font-family: roboto,sans-serif;
            text-align: center;
        }
        button{
            margin-top: 30px;
            border-radius: 10px;
            width: 80%;
            height: 50px;
            background-color:#d0011b;
            font-size: 20px;
            color: white;
            border:none;
            outline: none;
        }
        h3 button{
            margin-top: 10px;
            border-radius: 10px;
            width: 70%;
            height: 50px;
            background-color:#d0011b;
            font-size: 20px;
            color: white;
            border:none;
            outline: none;
        }
        .right{
            width: 60%;
        }
        img{
            width: 100%;
        }
    </style>
    <div class="container">
        <div class="hehe">
            <div class="left">
                <h2>Đặt hàng thành công</h2>
                <h2><a href="{{asset('/shop')}}"><button>Tiếp tục mua hàng</button></a></h2>
                <h3><a href="{{asset('/profile?order')}}"><button>Chi tiết đơn hàng</button></a></h3>
            </div>
            <div class="right">
                <img src="{{asset('images/logo/ordersuccess.jpg')}}" alt="">
            </div>
        </div>
    </div>
@stop()

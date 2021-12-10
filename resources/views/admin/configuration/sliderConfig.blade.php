@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Danh sách slider</h3>
                <div class="card-body">
                    @if(session()->has('delete-success'))
                        <div class="alert alert-success col-12">
                            {{session('delete-success')}}
                        </div>
                        @php
                            \Session::forget('delete-success');
                        @endphp
                    @endif
                    <div class="table-responsive">
                        <table
                            id="table"
                            class="table table-striped table-bordered first">
                            <thead class="bg-dark">
                            <tr>
                                <th>STT</th>
                                <th style="width: 200px;">Hình Ảnh</th>
                                <th>Nội Dung Khuyến Mãi</th>
                                <th>Nội Dung Sự Kiện</th>
                                <th>Trạng thái</th>
                                {{--                                <th>Ngày tạo</th>--}}
                                <th >Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $key => $slider)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td><img style="width:100%" src="{{asset('./images/slider/'.$slider->Images)}}"
                                             alt=""></td>
                                    <td>{{$slider->Discount}}</td>
                                    <td>{{$slider->Content}}</td>
                                    <td style="">
                                        @if($slider->Active)
                                            <span class="badge badge-success">Đang kích hoạt</span>
                                        @else
                                            <span class="badge badge-danger">Chưa kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{asset('/admin/config-edit-slider/'.$slider->SliderId)}}">
                                            <button class="btn btn-outline-info"><i class="fab fa-edit"></i>Cập nhật
                                            </button>
                                        </a>
                                        <a href="{{asset('/admin/delete-slider/'.$slider->SliderId)}}" onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                            <button class="btn btn-outline-danger"><i class="fab fa-trash"></i>Xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{route('config.add.slider')}}" class="btn btn-outline-primary">Tạo mới</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()

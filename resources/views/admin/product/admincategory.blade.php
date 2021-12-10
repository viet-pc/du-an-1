@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Danh mục sản phẩm</h3>
                @if(session()->has('del-success'))
                    <div class="alert alert-danger col3">
                        <strong>Bạn đã xóa thành công danh mục "{{session()->pull('del-success')}}"</strong>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="table"
                            class="table table-striped table-bordered first">
                            <thead style="background-color: #0e0c28;">
                            <tr>
                                <th>ID</th>
                                <th>Tên Danh Mục</th>
                                <th style="width: 100px;">Hình Ảnh</th>
                                <th>Slug</th>
                                <th>Hoạt động</th>
                                {{--                                <th>Ngày tạo</th>--}}
                                <th style="width: 100px;">Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categoryAll as $cat)
                                <tr>
                                    <td>{{$cat->CategoryId}}</td>
                                    <td>{{$cat->CategoryName}}</td>
                                    <td><img style="width:80%" src="{{asset('./images/product/'.$cat->CategoryImage)}}"
                                             alt=""></td>
                                    <td>{{$cat->CategorySlug}}</td>
                                    <td>
                                        @if($cat->CatActive==1)
                                            Đang hoạt động
                                        @else
                                            Không hoạt động
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row" style="justify-content:center">
                                            <x-permission per="Edit"
                                                          href="{{asset('admin/product/edit-category/'.$cat->CategorySlug)}}"></x-permission>
                                            <x-permission per="Delete"
                                                          href="{{asset('admin/product/delete-category/'.$cat->CategorySlug)}}"></x-permission>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()

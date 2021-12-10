@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="d-flex justify-content-between " style="border-bottom: 1px solid #e6e6f2">
                    <h3 class="card-header "> Danh sách bình luận </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="table"
                            class="table table-striped table-bordered first"
                        >
                            <thead style="background-color: var(--cyan)">
                            <tr>
                                <th>HÀNG HÓA</th>
                                <th>SỐ BÌNH LUẬN</th>
                                <th>MỚI NHẤT</th>
                                <th>CỦ NHẤT</th>
                                <th>CHI TIẾT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{$comment->ProductName}}</td>
                                    <td>{{$comment->quantity}}</td>
                                    <td>{{$comment->minDate}}</td>
                                    <td>{{$comment->maxDate}}</td>
                                    <td style="text-align:center"><a href="{{url('/admin/comment/'.$comment->Slug)}}" class="btn btn-outline-primary"><i class="fab fa-info"></i> Chi tiết</a> </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic table  -->
        <!-- ============================================================== -->
    </div>
@stop()

@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="d-flex justify-content-between " style="border-bottom: 1px solid #e6e6f2">
                    <h3 class="card-header ">Danh sách bình luận theo sản phẩm </h3>
                </div>
                <div class="card-body d-flex">
                    <img class="img-responsive" height="100px" src="{{asset('images/product/'.$comments['0']->Images)}}" alt="anhsp">
                    <h3><?php echo($comments['0']->ProductName) ?> </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="table"
                            class="table table-striped table-bordered first"
                        >
                            <thead style="background-color: var(--cyan)">
                            <tr>
                                <th>NGÀY BÌNH LUẬN</th>
                                <th>NỘI DUNG</th>
                                <th>NGƯỜI BÌNH LUẬN</th>
                                <th>XÓA</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{$comment->CreateAt}}</td>
                                    <td>{{$comment->Content}}</td>
                                    <td>{{$comment->Fullname}}</td>
                                    <td style="text-align: center"><a href="{{url('/admin/deleteComment/'.$comment->CommentId)}}" onclick="return confirm('Bạn có chắc muốn xóa bình luận này không này không?')" class="btn btn-outline-danger"><i class="fab fa-trash"></i> Xóa</a> </td>
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

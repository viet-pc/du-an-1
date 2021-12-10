@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Danh sách bài viết</h3>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="blogTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width:3px">#</th>
                                <th >Thumbnail</th>
                                <th style="max-width:100px">Tiêu đề</th>
                                <th >Danh mục</th>
                                <th >Đăng bởi</th>
                                <th >Lượt xem</th>
                                <th >Lượt bình luận</th>
                                <th >Tuỳ chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <th >{{$item->id}}</th>
                                    <td><img width="80px" src="{{asset('images/blog')}}/{{$item->thumbnail}}"
                                             class="rounded" alt="{{$item->title}}"></td>
                                    <td><a>{{$item->title}}</a></td>
                                    <td>{{$item->category}}</td>
                                    <td>{{$item->author}}</td>
                                    <td>{{$item->views}}</td>
                                    <td>
                                        @foreach($commentData as $cmt)
                                            @if($cmt->postId == $item->id)
                                                {{$cmt->count}}
                                            @else
                                            @endif()
                                        @endforeach()
                                    </td>
                                    <td>
                                        <a href="{{url('admin/blog/'.$item->id.'/commentList')}}" type="button"
                                           class="btn btn-outline-primary"><i class="fab fa-info"></i>Xem bình luận</a>
                                        <a href="{{url('admin/blog/'.$item->id.'/edit')}}" type="button"
                                           class="btn btn-outline-primary"><i class="fab fa-edit"></i>Sửa</a>
                                        <button value="{{$item->id}}" onclick="deleteRq(this)" type="button"
                                                class="btn btn-outline-danger"><i class="fab fa-trash"></i>Xoá
                                        </button>
                                    </td>
                                </tr>
                            @endforeach()
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
    <script type="text/javascript">
        function deleteRq(a) {
            Notiflix.Confirm.Show(
                'Bạn muốn xoá bài viết này?',
                'Bài viết và bình luận của bài viết này sẽ bị xoá và không thể khôi phục.',
                'Xoá',
                'Huỷ',
                function okCb() {
                    $.ajax({
                        url: "{{url('api/post/delete')}}",
                        type: 'POST',
                        data: {
                            id: a.getAttribute('value'),
                            _token: "{{csrf_token()}}"
                        }
                    }).done(function (res) {
                        if (res.success == true) {
                            Notiflix.Notify.Success(res.msg);
                            a.parentNode.parentNode.remove();
                        } else {
                            Notiflix.Notify.Warning(res.msg);
                        }
                    });
                }
            );
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#blogTable").DataTable({
                lengthMenu: [10, 20, 30],
                language: {
                    processing: "Đang tải dữ liệu",
                    search: "Tìm kiếm: ",
                    lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
                    info: "_START_ - _END_ / _TOTAL_",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(Trên tổng _MAX_ mục)",
                    infoPostFix: " bài viết", // Cái này khi thêm vào nó sẽ đứng sau info
                    loadingRecords: "",
                    zeroRecords: "Không tồn tại dữ liệu cần tìm",
                    emptyTable: "Không có dữ liệu",
                    paginate: {
                        first: "Trang đầu",
                        previous: "<",
                        next: ">",
                        last: "Trang cuối",
                    },
                    aria: {
                        sortAscending: ": Đang sắp xếp theo column",
                        sortDescending: ": Đang sắp xếp theo column",
                    },
                },
            });
        });
    </script>
@stop()

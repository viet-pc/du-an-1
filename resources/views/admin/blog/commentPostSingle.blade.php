@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if(count($data) > 0)
            <div class="card">
                <h3 class="card-header">Danh sách bình luận của bài viết "{{$data[0]->Title}}"</h3>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="commentTable" class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Người bình luận</th>
                                <th scope="col">Ngày bình luận</th>
                                <th scope="col">Tuỳ chọn</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                              <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->message}}</td>
                                <td>{{$item->Fullname}}</td>
                                <td>{{$item->createAt}}</th>
                                <td>
                                  <a value="{{$item->id}}" onclick="{{($item->status == 0) ? 'active(this)' :  "unactive(this)"}}" type="button" class="btn btn-primary text-white p-1">{{($item->status == 0) ? 'Duyệt' :  "Huỷ duyệt"}}</a>
                                  <button value="{{$item->id}}" onclick="deleteRq(this)" type="button" class="btn btn-danger text-white p-1">Xoá</button>
                                </td>
                            </tr>
                            @endforeach()
                            </tbody>
                          </table>

                    </div>
                </div>
            </div>
            @else
            <center>Bài viết này chưa có bình luận nào</center>
            @endif
        </div>
    </div>
@stop()
@section('scripts')
<script type="text/javascript">
  function deleteRq(a) {
    Notiflix.Confirm.Show(
      'Bạn muốn xoá bình luận này?',
      'Sau khi xoá sẽ không thể khôi phục.',
      'Xoá',
      'Huỷ',
      function okCb(){
        id = a.getAttribute('value');
        $.ajax({
            url: '{{url("api/post/comment")}}/'+id+'/delete',
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
              Notiflix.Notify.Success(res.messages);
              a.parentNode.parentNode.remove();
            }else{
              Notiflix.Notify.Warning(res.messages);
            }
        });
      }
    );
  }

  function unactive(a){
    id = a.getAttribute('value');
    $.ajax({
            url: '{{url("api/post/comment")}}/'+id+'/unactive',
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
              Notiflix.Notify.Success(res.messages);
              setTimeout(function () { location.reload(true); }, 2000);
            }else{
              Notiflix.Notify.Warning(res.messages);
            }
        });
  }

  function active(a){
    id = a.getAttribute('value');
    $.ajax({
            url: '{{url("api/post/comment")}}/'+id+'/active',
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
              Notiflix.Notify.Success(res.messages);
              setTimeout(function () { location.reload(true); }, 2000);
            }else{
              Notiflix.Notify.Warning(res.messages);
            }
        });
  }
</script>
<script>
  $(document).ready(function () {
    $("#commentTable").DataTable({
        lengthMenu: [10, 20, 30],
        language: {
            processing: "Đang tải dữ liệu",
            search: "Tìm kiếm: ",
            lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
            info: "_START_ - _END_ / _TOTAL_",
            infoEmpty: "Không có dữ liệu",
            infoFiltered: "(Trên tổng _MAX_ mục)",
            infoPostFix: " bình luận", // Cái này khi thêm vào nó sẽ đứng sau info
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

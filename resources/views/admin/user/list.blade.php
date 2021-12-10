@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if(count($data) > 0)
            <div class="card">
                <h3 class="card-header">Quản lý người dùng</h3>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Điện thoại</th>
                                <th scope="col">Đăng nhập Facebook</th>
                                <th scope="col">Đăng nhập Google</th>
                                <th scope="col">Tuỳ chọn</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                              <tr>
                                <td>{{$item->UserId}}</td>
                                <td>{{$item->Fullname}}</td>
                                <td>{{$item->Email}}</td>
                                <td>{{$item->Phone}}</td>
                                <td>{{($item->facebook_id != NULL) ? '✓' : ''}}</th>
                                <td>{{($item->google_id != NULL) ? '✓' : ''}}</th>
                                <td>
                                    <a href="{{url('admin/users/' . $item->UserId.'/detail')}}" target="_blank"type="button" class="btn btn-outline-primary"><i class="fab fa-info"></i>Chi tiết</a>
                                    <a value="{{$item->UserId}}" onclick="{{($item->Active == 0) ? 'active(this)' :  "unactive(this)"}}" type="button" class="btn btn-outline-primary"> <i class='fab fa-{{($item->Active == 0) ?'unlock':'lock' }}'></i>{{($item->Active == 0) ? 'Mở khoá' :  "Khoá"}}</a>
                                    <button value="{{$item->UserId}}" onclick="deleteRq(this)" type="button" class="btn btn-outline-danger"><i class="fab fa-trash"></i>Xoá</button>
                                </td>
                            </tr>
                            @endforeach()
                            </tbody>
                          </table>

                    </div>
                </div>
            </div>
            @else
            <center>Chưa có bình luận mới cần duyệt</center>
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

  function active(a){
    id = a.getAttribute('value');
    $.ajax({
            url: '{{url("api/user")}}/'+id+'/active',
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
                Notiflix.Notify.Success(res.messages);
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            }else{
                Notiflix.Notify.Warning(res.messages);
            }
        });
  }

  function unactive(a){
    id = a.getAttribute('value');
    $.ajax({
            url: '{{url("api/user")}}/'+id+'/unactive',
            type: 'POST',
            data: {
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {;
            if(res.success == true){
                Notiflix.Notify.Success(res.messages);
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            }else{
                Notiflix.Notify.Warning(res.messages);
            }
        });
  }
</script>
<script>
    $(document).ready(function () {
      $("#usersTable").DataTable({
          lengthMenu: [10, 20, 30],
          language: {
              processing: "Đang tải dữ liệu",
              search: "Tìm kiếm: ",
              lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
              info: "_START_ - _END_ / _TOTAL_",
              infoEmpty: "Không có dữ liệu",
              infoFiltered: "(Trên tổng _MAX_ mục)",
              infoPostFix: " người dùng", // Cái này khi thêm vào nó sẽ đứng sau info
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

@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Thông tin người dùng</h3>
                <div class="card-body">
                    <form id="pulseForm">
                        <div class="form-group">
                          <label for="name">Tên</label>
                          <input type="text" class="form-control" id="name" value="{{$data->Fullname}}" disabled placeholder="Nhập tên người dùng">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" value="{{$data->Phone}}" disabled placeholder="Nhập số điện thoại">
                        </div>
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input id="email" class="form-control"disabled value="{{$data->Email}}" placeholder="Nhập email người dùng">
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input id="address" class="form-control"disabled value="{{$data->Address}}" placeholder="Nhập địa chỉ người dùng">
                        </div>
                        <div class="form-group">
                            <label>Tình trạng:</label>
                            <span>{{($data->Active) == 1 ? 'Hoạt động' : 'Bị khoá'}}</span>
                        </div>
                        <div class="form-group p-4">
                            <button value="{{$data->UserId}}" type="button" onclick="{{($data->Active == 0) ? 'active(this)' :  "unactive(this)"}}" class="btn btn-danger waves-effect waves-light">{{($data->Active) == 1 ? 'Khoá' : 'Mở khoá'}}</button>
                            @if(Session::has('Edit') || Session::has('Full'))
                                <button onclick="editReady()" id="edit" type="button" class="btn btn-primary waves-effect waves-light">Sửa thông tin</button>
                            @endif
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePassModal">Đặt lại mật khẩu</button>
                            <button style="display: none" id="post" type="button" class="btn btn-primary waves-effect waves-light">Lưu</button>
                        </div>
                      </form>
                </div>
            </div>

            <div class="card">
                <h3 class="card-header">Đơn hàng gần đây của {{$data->Fullname}} ({{count($orders)}})</h3>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="orderTable" class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Người nhận</th>
                                <th scope="col">Điện thoại</th>
                                <th scope="col">Ngày mua</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Ghi chú</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Tuỳ chọn</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                              <tr>
                                <th scope="row">{{$item->OrderId}}</th>
                                <td><a>{{$item->Fullname}}</a></td>
                                <td>{{$item->Phone}}</td>
                                <td>{{$item->CreateAt}}</td>
                                <td>{{$item->StatusName}}</td>
                                <td>{{$item->Note}}</td>
                                <td>{{number_format($item->ToPay)}}đ</td>
                                <td>
                                  <a href="{{url('admin/order/order-detail')}}/{{$item->OrderId}}" type="button" class="btn btn-outline-primary p-1"><i class="fab fa-edit"></i>Chi tiết</a>
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

    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePassModal" aria-hidden="true">
        <div class="modal-dialog" role="document" id="changePassForm">
            <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Đặt lại mật khẩu</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Mật khẩu mới:</label>
                    <input require="required" type="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="repeatPassword" class="col-form-label">Nhập lại mật khẩu mới:</label>
                    <input require="required" type="password" class="form-control" id="repeatPassword">
                </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    <button type="button" onclick="changePassword()" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>


@stop()
@section('scripts')
<script>

    id = {{$data->UserId}};
    function editReady(){
        $('#name').prop("disabled", false);
        $('#phone').prop("disabled", false);
        $('#fullname').prop("disabled", false);
        $('#address').prop("disabled", false);
        $('#email').prop("disabled", false);
        $("#post").show();
        $('#edit').prop('disabled', true);
    }
    $(document).ready(function() {
        $('#post').click(function(e) {
            Notiflix.Block.Pulse('#pulseForm');
            e.preventDefault();
            $.ajax({
                url: "{{url('api/user/'.$data->UserId.'/update')}}",
                type: 'POST',
                data: {
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    address: $('#address').val(),
                    _token: "{{csrf_token()}}"
                }
            }).done(function(res) {
                Notiflix.Block.Remove('#pulseForm');
                if(res.success == true){
                    Notiflix.Notify.Success(res.messages);
                    $('#name').prop("disabled", true);
                    $('#phone').prop("disabled", true);
                    $('#fullname').prop("disabled", true);
                    $('#address').prop("disabled", true);
                    $('#address').prop("disabled", true);
                    $('#email').prop('disabled', true);
                    $('#edit').prop('disabled', false);
                    $('#post').hide();
                }else{
                    Notiflix.Notify.Warning(res.messages);
                }
            });
        });
    });

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

    function changePassword(){
        Notiflix.Block.Pulse('#changePassForm');
        $.ajax({
            url: "{{url('api/user/'.$data->UserId.'/changePassword')}}",
            type: 'POST',
            data: {
                password: $('#password').val(),
                repeatPassword: $('#repeatPassword').val(),
                _token: "{{csrf_token()}}"
            }
        }).done(function(res) {
            Notiflix.Block.Remove('#changePassForm');
            if(res.success == true){
                Notiflix.Notify.Success(res.messages);
                $('#password').val('');
                $('#repeatPassword').val('');
                $('#changePassModal').modal('hide');
            }else{
                Notiflix.Notify.Warning(res.messages);
            }
        })
    }
</script>
<script>
    $(document).ready(function () {
        $("#orderTable").DataTable({
            lengthMenu: [10, 20, 30],
            language: {
                processing: "Đang tải dữ liệu",
                search: "Tìm kiếm: ",
                lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
                info: "_START_ - _END_ / _TOTAL_",
                infoEmpty: "Không có dữ liệu",
                infoFiltered: "(Trên tổng _MAX_ mục)",
                infoPostFix: " đơn hàng", // Cái này khi thêm vào nó sẽ đứng sau info
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

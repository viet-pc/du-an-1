@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Xếp hạng chi tiêu thành viên</h3>
                    <div class="table-responsive">
                        <table id="top" class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">Hạng</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tổng đơn thành công</th>
                                <th scope="col">Tổng tiền chi tiêu</th>
                                <th scope="col">Tuỳ chọn</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                              <tr>
                                <th scope="row">{{$item->no}}</th>
                                <td><a>{{$item->Fullname}}</a></td>
                                <td>{{number_format($item->count)}}</td>
                                <td>{{number_format($item->sum)}}đ</td>
                                <td>
                                  @if(Session::has('View') || Session::has('Full'))
                                    <a href="{{url('admin/users/'.$item->UserId.'/detail')}}" type="button" class="btn btn-outline-info">Chi tiết</a>
                                  @endif
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
<script>
  $(document).ready(function () {
      $("#top").DataTable({
          lengthMenu: [10, 20, 30],
          language: {
              processing: "Đang tải dữ liệu",
              search: "Tìm kiếm: ",
              lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
              info: "_START_ - _END_ / _TOTAL_",
              infoEmpty: "Không có dữ liệu",
              infoFiltered: "(Trên tổng _MAX_ mục)",
              infoPostFix: " hạng mục", // Cái này khi thêm vào nó sẽ đứng sau info
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

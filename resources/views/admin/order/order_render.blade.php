<table id="tableOrder2" class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Họ và tên</th>
        <th scope="col">Ngày mua</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Tồng tiền</th>
        <th scope="col">Thao tác</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $item)
        <tr>
            <th scope="row">{{$item->OrderId}}</th>
            <td>{{$item->Fullname}}</td>
            <td>{{$item->CreateAt}}</td>
            @if ($item->StatusId == 1 || $item->StatusId == 5)
                <td style="color: #d0011b;">{{$item->StatusName}}</td>
            @elseif ($item->StatusId == 4)
                <td style="color: #1bc88c;">{{$item->StatusName}}</td>
            @else
                <td style="color: orange;">{{$item->StatusName}}</td>
            @endif
            <td><b>{{number_format($item->ToPay)}} VNĐ</b></td>
            <td>
                <a href="{{url('admin/order/order-detail/'.$item->OrderId)}}" type="button" class="btn btn-primary text-white p-1">Chi tiết</a>
            </td>
        </tr>
    @endforeach()
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tableOrder2").DataTable({
            lengthMenu: [10, 20, 30],
            "order": [[0, "desc"]],
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

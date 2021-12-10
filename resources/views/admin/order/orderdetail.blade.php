@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Chi tiết đơn hàng <a href="{{Route('admin.order')}}">#{{$orderDetail[0]->OrderId}}</a></h3>
                <div class="card-body">
                    <h3>Thông tin khách hàng!</h3>
                    <p style="margin: 6px;">Họ tên: {{$orderDetail[0]->Fullname}}</p>
                    <p style="margin: 6px;">Email: {{$orderDetail[0]->Email}}</p>
                    <p style="margin: 6px;">Số điện thoại: {{$orderDetail[0]->Phone}}</p>
                    <p style="margin: 6px;">Địa chỉ: {{$orderDetail[0]->Address}}</p>
                    <p style="margin: 6px;">Ngày đặt hàng: {{$orderDetail[0]->CreateAt}}</p>
                    <div class="form-group" style="padding: 15px 0px;">
                        <?php $i = 0?>
                        @foreach($status as $value)
                            @if ($value->StatusId == $orderDetail[0]->StatusId)
                                @if($value->StatusId == 1)
                                    <button style="text-transform: capitalize;" name="btnUpdateStatus" data-id="{{$orderDetail[0]->OrderId}}" data-status="5" class="btn btn-danger btn-sm">Hủy đơn</button>
                                @endif
                                <?php $i++; ?>
                                @continue
                            @endif
                            @if($i == 1 && $value->Status)
                                <button style="text-transform: capitalize;" name="btnUpdateStatus" data-id="{{$orderDetail[0]->OrderId}}" data-status="{{$value->StatusId}}" class="btn btn-primary btn-sm">{{$value->Status}}</button>
                                @break
                            @endif
                        @endforeach
                    </div>
                    <div class="table-responsive">
                        <table id="tableOrderDetail" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Đơn giá</th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($orderDetail as $item)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td><img width="100px" src="{{asset('images/product')}}/{{$item->Color}}" class="rounded" alt="{{$item->VariantName}}"></td>
                                    <td>{{$item->VariantName}}</td>
                                    <td>{{$item->Quantity}}</td>
                                    <td><b>{{number_format($item->ProductPrice + ($item->ProductPrice * $item->VariantPrice))}} VNĐ</b></td>
                                    <td><b>{{number_format($item->Quantity * ($item->ProductPrice + ($item->ProductPrice * $item->VariantPrice)))}} VNĐ</b></td>
                                </tr>
                            @endforeach()
                            </tbody>
                        </table>
                        <p style="text-align: left; font-size: 16px; margin-top: 15px;">Phí vận chuyển: <b>{{number_format($orderDetail[0]->ShipFee)}} VNĐ</b></p>
                        <p style="text-align: left; font-size: 18px; margin-top: 15px;">Tổng tiền: <b>{{number_format($orderDetail[0]->ToPay)}} VNĐ</b></p>
                    </div>
                    @if ($userRole == 'Manager' || $userRole == 'SuperAdmin')
                    <div style="margin-top: 15px;">
                        <hr>
                        <h3>Lịch sử</h3>
                        @foreach($historyOrder as $item)
                            <p><b>{{$item->CreateAt}}</b>: {{$item->Description}}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tableOrderDetail").DataTable({
                lengthMenu: [10, 20, 30],
                language: {
                    processing: "Đang tải dữ liệu",
                    search: "Tìm kiếm: ",
                    lengthMenu: "Lượng hiển thị:  " + " _MENU_ ",
                    info: "_START_ - _END_ / _TOTAL_",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(Trên tổng _MAX_ mục)",
                    infoPostFix: " chi tiết đơn hàng", // Cái này khi thêm vào nó sẽ đứng sau info
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

        $('button[name="btnUpdateStatus"]').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type : 'GET',
                url  : "{{url('/admin/order/update-status')}}/"+$(this).data('id')+'/'+$(this).data('status'),
            }).done(function (response) {
                if (response) {
                    Notiflix.Block.Standard('html');
                    Notiflix.Notify.Success("Cập nhật trạng thái đơn hàng thành công!");
                    setInterval(function () {
                        window.location.href = '/admin/order';
                    }, 400)
                }
            });
        });
    </script>
@stop()

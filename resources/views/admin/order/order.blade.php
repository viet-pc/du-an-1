@extends('layouts.admin')
@section('main')
    <style>
        .tabs-ui {
            margin: 0 0 20px 0;
            max-width: 100%;
        }
        .tabs {
            display: flex;
            position: relative;
        }
        .tabs .line {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 6px;
            border-radius: 15px;
            background-color: #5969ff;
            transition: all 0.2s ease;
        }
        .tab-item {
            width: 150px;
            padding: 15px 10px 10px 10px;
            font-size: 16px;
            text-align: center;
            color: black;
            background-color: #fff;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom: 5px solid transparent;
            opacity: 0.6;
            cursor: pointer;
            transition: all 0.5s ease;
        }
        .tab-item:hover {
            opacity: 1;
            background-color: rgba(89, 105, 255, 0.08);
            border-color: rgba(89, 105, 255, 0.51);
        }
        .tab-item.active {
            opacity: 1;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Danh sách đơn hàng</h3>
                <div class="card-body">
                    <div class="tabs-ui">
                        <!-- Tab items -->
                        <div class="tabs">
                            @if ($userRole->RoleName == 'Manager' || $userRole->RoleName == 'SuperAdmin')
                                <div class="tab-item" data-id="0">
                                    Tất cả đơn hàng
                                </div>
                                @foreach($status as $item)
                                    <div class="tab-item" data-id="{{$item->StatusId}}">
                                        {{$item->StatusName}}
                                    </div>
                                @endforeach
                            @elseif ($userRole->RoleName == 'Sale')
                                @foreach($status as $item)
                                    @if ($item->StatusName == 'Đang chờ xử lí' || $item->StatusName == 'Đã hủy')
                                        <div class="tab-item" data-id="{{$item->StatusId}}">
                                            {{$item->StatusName}}
                                        </div>
                                    @endif
                                @endforeach
                            @elseif ($userRole->RoleName == 'Warehouse')
                                @foreach($status as $item)
                                    @if ($item->StatusName == 'Đã xác nhận')
                                        <div class="tab-item" data-id="{{$item->StatusId}}">
                                            {{$item->StatusName}}
                                        </div>
                                    @endif
                                @endforeach
                            @elseif ($userRole->RoleName == 'Shipper')
                                @foreach($status as $item)
                                    @if ($item->StatusName == 'Đang giao hàng')
                                        <div class="tab-item" data-id="{{$item->StatusId}}">
                                            {{$item->StatusName}}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="line"></div>
                        </div>
                    </div>
                    <div class="table-responsive" id="table-responsive">
                        <table id="tableOrder1" class="table table-striped">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tableOrder1").DataTable({
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
    <script type="text/javascript">
        const tabs = document.querySelectorAll('.tab-item');
        tabs[0].classList.add('active');

        const tabActive = document.querySelector(".tab-item.active");
        const line = document.querySelector(".tabs .line");

        line.style.left = tabActive.offsetLeft + "px";
        line.style.width = tabActive.offsetWidth + "px";

        tabs.forEach((tab, index) => {
            tab.onclick = function () {
                tabActive.classList.remove("active");
                line.style.left = this.offsetLeft + "px";
                line.style.width = this.offsetWidth + "px";
                this.classList.add("active");

                $.ajax({
                    type : 'GET',
                    url  : "{{url('/admin/order/order-by-status')}}/"+$(this).data('id'),
                }).done(function (response) {
                    if (response) {
                        $('#table-responsive').empty();
                        $('#table-responsive').html(response);
                    }
                });
            };
        });
    </script>
@stop()

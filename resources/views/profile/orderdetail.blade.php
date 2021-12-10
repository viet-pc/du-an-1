<div class="modal modal--show">
    <div class="modal__overlay"></div>
    <div class="modal__body">
        <div class="myaccount-table myaccount-table2 table-responsive text-center">
            <table class="table table-bordered">
                <thead class="thead-light thead-light2">
                <tr>
                    <th>STT</th>
                    <th>Hình</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Thành Tiền</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($orderDetail as $item)
                    <tr>
                        <td class="agl-center-text">{{$i++}}</td>
                        <td class="agl-center-text"><img style="width: 100px;" src="{{'images/product/'.$item->Color}}" alt=""></td>
                        <td class="agl-center-text">{{$item->VariantName}}</td>
                        <td class="agl-center-text">{{$item->Quantity}}</td>
                        <td class="agl-center-text">{{number_format($item->ProductPrice + ($item->ProductPrice * $item->VariantPrice))}} VNĐ</td>
                        <td class="agl-center-text">{{number_format($item->Quantity * ($item->ProductPrice + ($item->ProductPrice * $item->VariantPrice)))}} VNĐ</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; flex-direction: row; flex-wrap: wrap; align-items: start; width: 100%; justify-content: space-between; margin-top: 15px;">
            <div>
                <p>Ngày giao hàng(dự kiến): <b>{{$orderDetail[0]->ShipDate}}</b></p>
            </div>
            <div>
                <p>Phí vận chuyển: <b>{{number_format($orderDetail[0]->ShipFee)}} VNĐ</b></p>
                <p style="font-size: 16px;">Tổng tiền: <b>{{number_format($orderDetail[0]->ToPay)}} VNĐ</b></p>
            </div>
        </div>

    </div>
</div>

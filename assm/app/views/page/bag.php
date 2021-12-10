<section id="bag">
    <div class="container">
        <div class="gio-sanpham">
            <table>
                <thead>
                    <tr>
                        <th class="o-lon" colspan="10">Bạn đang có 2 san phẩm trong giỏ hàng</th>
                        <th class="nho">Số Lượng</th>
                        <th class="nho">Đơn Giá</th>
                        <th class="nho">Số Tiền</th>
                    </tr>
                </thead>
                <tbody id="table-item">
                </tbody>
            </table>
            <div id="tinnhan">
                <img src="./img/chuacohang.png" alt="">
                <p>Không có sản phẩm nào trong giỏ hàng của bạn.</p>
                <a href=<?= BASE_URL + "sanpham.html" ?>><button onclick="mat()">Tiếp tục mua sắm</button></a>

            </div>
        </div>
        <div class="tiptucdoihang">
            <div class="tieptuc">Tiếp tục mua hàng →</div>
            <div class="donhang">
                <div class="text">Thông tin đơn hàng</div>
                <hr>
                <div class="tien">
                    <div>Tổng tiền: </div>
                    <div>515,000đ</div>
                </div>
                <hr>
                <div class="thongtin">Bạn có thể nhập mã giảm giá ở trang thanh toán</div>
                <button class="thanhtoan">THANH TOÁN</button>
            </div>
        </div>
        <div class="giaohang">
            <i class="fas fa-truck"></i> Miễn Phí Vận Chuyển cho đơn hàng từ ₫50.000 (giảm tối đa ₫20.000);
        </div>
    </div>
</section>
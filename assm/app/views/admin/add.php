<table class="table table-hover table-dark" id="table_id">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tên</th>
            <th scope="col">Giá</th>
            <th scope="col">Nhà SX</th>
            <th scope="col">Loại</th>
            <th scope="col">Ảnh Chính</th>
            <th scope="col">Ảnh chi tiết</th>
            <th scope="col">sữa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['sp'] as $item) :
        ?>
            <tr>
                <th class="id" scope="row"><?php echo $item['MaSP'] ?></th>
                <td><?php echo $item['TenSP'] ?></td>
                <td><?php echo $item['GiaMoi'] ?></td>
                <td><?php echo $item['TenNSX'] ?></td>
                <td><?php echo $item['TenLoai'] ?></td>
                <td><img width=50 src="<?php echo BASE_URL . './img/' . $item['anh1'] ?>" alt=""></td>
                <td>
                    <img width=50 src="<?php echo BASE_URL . './img/' . $item['anh2'] ?>" alt="">
                    <img width=50 src="<?php echo BASE_URL . './img/' . $item['anh3'] ?>" alt="">
                    <img width=50 src="<?php echo BASE_URL . './img/' . $item['anh4'] ?>" alt="">
                </td>
                <td>
                    <a href="<?php echo BASE_URL . 'admin/xoa?xoaid=' . $item['MaSP']; ?>" class="btn btn-outline-danger">xóa</a>
                    <button class="btn btn-outline-success change">thay đổi</button>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>
<tr>
    <a href="admin/themsp" onclick="add()" class="btn btn-outline-primary">Thêm SP</a>
</tr>
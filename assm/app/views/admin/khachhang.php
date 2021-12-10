<form action="<?php echo  BASE_URL . 'admin/themkh' ?>" method="post" enctype="multipart/form-data">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên Khách Hầng </th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Số Điện Thoại</th>
                <th scope="col">Thay Đổi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['kh'] as $kh) :
            ?>
                <tr>
                    <td class="id" scope="row"><?php echo $kh['MaKH'] ?></td>
                    <td><?php echo $kh['HoTen'] ?></td>
                    <td><?php echo $kh['Email'] ?></td>
                    <td><?php echo $kh['DiaChi'] ?></td>
                    <td><?php echo $kh['username'] ?></td>
                    <td><?php echo $kh['password'] ?></td>
                    <td><?php echo $kh['SoDT'] ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . 'admin/xoakh?xoaid=' . $kh['MaKH']; ?>" class="btn btn-outline-danger">xóa</a>
                        <div class="changekh btn btn-outline-success">thay đổi</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</form>
<h4><?= !isset($data['mess']) ? '' : $data['mess'] ?></h4>
<button id="addkh" class=" btn btn-outline-primary">Thêm</button>
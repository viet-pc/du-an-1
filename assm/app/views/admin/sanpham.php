<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 1200px;
        width: 100%;
        padding: 0;
        margin: auto;
    }

    table,
    thead,
    tbody {
        max-width: 1200px;
        width: 100%;
    }

    tr {
        border: none;
        width: 1200px;
        display: grid;
        grid-gap: 0;
        grid-template-columns: 30px 180px 95px 95px 95px 95px 95px 80px 220px 220px;
    }

    td {
        border: none;
        align-self: center;
    }

    form {
        max-width: 1200px;
    }

    select,
    input {
        width: 90px;
    }

    input[name="tensp"] {
        width: 150px;
    }

    .table tr td:nth-child(9) {
        padding-left: 20px;
    }

    .table td,
    .table th {
        border: none;
        padding: 5px;
    }
</style>


<form action="<?php echo  BASE_URL . 'admin/them' ?>" method="post" enctype="multipart/form-data">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Giá củ</th>
                <th scope="col">Giá mới</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Nhà SX</th>
                <th scope="col">Loại</th>
                <th scope="col">Ảnh Chính</th>
                <th scope="col">Ảnh chi tiết</th>
                <th scope="col">sữa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['sp'] as $sp) :
            ?>
                <tr>
                    <td class="id" scope="row"><?php echo $sp['MaSP'] ?></td>
                    <td><?php echo $sp['TenSP'] ?></td>
                    <td><?php echo $sp['GiaCu'] ?></td>
                    <td><?php echo $sp['GiaMoi'] ?></td>
                    <td><?php echo $sp['gioitinh'] ?></td>
                    <td><?php echo $sp['TenNSX'] ?></td>
                    <td><?php echo $sp['TenLoai'] ?></td>
                    <td><img width=50 src="<?php echo BASE_URL . './img/' . $sp['anh1'] ?>" alt=""></td>
                    <td>
                        <?php
                        $i = 2;
                        while ($sp['anh' . $i]) {
                            echo ' <img width=50 src="' . BASE_URL  . './img/' . $sp['anh' . $i] . '" alt="">';
                            $i += 1;
                        }

                        ?>
                    </td>
                    <td>
                        <a href="<?php echo BASE_URL . 'admin/xoa?xoaid=' . $sp['MaSP']; ?>" class="btn btn-outline-danger">xóa</a>
                        <div class="changesp btn btn-outline-success">thay đổi</div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <!-- <form action="<?php echo  BASE_URL . 'admin/themsp' ?>" method="post" enctype="multipart/form-data">
            <tr>
                <td scope=" row">#</td>
                <td><input type="text" name="tensp" placeholder="nhập tên SP"></td>
                <td><input type="text" name="giaCu" placeholder="nhập Giá củ"></td>
                <td><input type="text" name="giamoi" placeholder="nhập Giá mới"></td>
                <td><input type="text" name="giotinh" placeholder="nhập Giới tính"></td>
                <td>
                    <select name="MaNSX">
                        <option>chọn NSX</option>
                        <?php
                        foreach ($data['nsx'] as $nsx) :
                        ?>
                            <option value="<?php echo $nsx['MaNSX'] ?>"> <?php echo $nsx['TenNSX'] ?></option>';
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="loaisp">
                        <option>chọnLoại</option>
                        <?php
                        foreach ($data['loai'] as $loai) :
                        ?>
                            <option value="<?php echo $loai['MaLoai'] ?>"> <?php echo $loai['TenLoai'] ?></option>';
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="file" name="anhchinh">
                <td>
                    <p>thêm ít nhất 3 ảnh</p>
                    <input type="file" name="anhphu[]" multiple="multiple">
                </td>
                <td>
                    <a href="<?php echo BASE_URL . 'admin' ?>" class="btn btn-outline-danger">hủy</a>
                    <input type="submit" class="btn btn-outline-success" value="Thêm sp" name="submit">
                </td>
            </tr>
        </form> -->

        </tbody>

    </table>
</form>
<h4><?= !isset($data['mess']) ? '' : $data['mess'] ?></h4>
<button id="addsp" class=" btn btn-outline-primary">Thêm</button>
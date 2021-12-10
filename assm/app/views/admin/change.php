<tr>
    <td><input name=" <?= $data['action'] ?>" value="<?php if (isset($data['sanpham'])) echo $data['sanpham']['MaSP']; ?>" type="text" class="d-none"> #</td>
    <td><input type="text" name="tensp" value="<?php if (isset($data['sanpham'])) echo $data['sanpham']['TenSP']; ?>" placeholder=" nhập tên SP"></td>
    <td><input type="text" name="giaCu" value="<?php if (isset($data['sanpham'])) echo $data['sanpham']['GiaCu']; ?>" placeholder="nhập Giá củ"></td>
    <td><input type="text" name="giamoi" value="<?php if (isset($data['sanpham'])) echo $data['sanpham']['GiaMoi']; ?>" placeholder="nhập Giá mới"></td>
    <td><input type="text" name="giotinh" value="<?php if (isset($data['sanpham'])) echo $data['sanpham']['gioitinh']; ?>" placeholder="nhập Giới tính"></td>
    <td>
        <select name="MaNSX">
            <option>chọn NSX</option>
            <?php
            foreach ($data['nsx'] as $nsx) :
            ?>
                <option value="<?php echo $nsx['MaNSX'] ?>" <?php if (isset($data['sanpham'])) echo $nsx['MaNSX'] != $data['sanpham']['MaNSX'] ?: 'selected="selected"' ?>> <?php echo $nsx['TenNSX'] ?></option>
            <?php endforeach; ?>
        </select>
    </td>
    <td>
        <select name="loaisp">
            <option>chọnLoại</option>
            <?php
            foreach ($data['loai'] as $loai) :
            ?>
                <option value="<?php echo $loai['MaLoai'] ?>" <?php if (isset($data['sanpham'])) echo $loai['MaLoai'] != $data['sanpham']['MaLoai'] ?: 'selected="selected"' ?>> <?php echo $loai['TenLoai'] ?> </option>
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
        <input type="submit" class="btn btn-outline-success" value="<?= $data['action'] == 'add' ? 'Thêm SP' : 'Cập Nhật' ?>" name="submit">
    </td>
</tr>
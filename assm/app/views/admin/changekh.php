<tr>
    <td><input name=" <?= $data['action'] ?>" value="<?php if (isset($data['kh'])) echo $data['kh']['MaKH']; ?>" type="text" class="d-none"> #</td>
    <td><input type="text" name="hvt" value="<?php if (isset($data['kh'])) echo $data['kh']['HoTen']; ?>" placeholder="Nhập họ tên"></td>
    <td><input type="email" name="email" value="<?php if (isset($data['kh'])) echo $data['kh']['Email']; ?>" placeholder="Nhập Email"></td>
    <td><input type="text" name="dc" value="<?php if (isset($data['kh'])) echo $data['kh']['DiaChi']; ?>" placeholder="Nhập Địa chỉ"></td>
    <td><input type="text" name="tdn" value="<?php if (isset($data['kh'])) echo $data['kh']['username']; ?>" placeholder="Nhập username"></td>
    <td><input type="password" name="pass" value="<?php if (isset($data['kh'])) echo $data['kh']['password']; ?>" placeholder="Nhập password" ?></td>
    <td><input type="int" name="sdt" value="<?php if (isset($data['kh'])) echo $data['kh']['SoDT']; ?>" placeholder="Nhập SoDT" ?></td>
    <td>
        <a href="<?php echo BASE_URL . 'admin' ?>" class="btn btn-outline-danger">hủy</a>
        <input type="submit" class="btn btn-outline-success" value="<?= $data['action'] == 'add' ? 'Thêm KH' : 'Cập Nhật' ?>" name="submit">
    </td>
</tr>
<?php
class ajax extends load
{
    function add_bag()
    {
        //unset($_SESSION['giohang']);
        //Tiếp nhận biến id (mã sản phẩm) và what (để biết thêm/xóa sp)
        $id = $_POST['id'];
        // settype($id, "int");
        if (isset($_SESSION['giohang']) == FALSE) {
            $_SESSION['giohang'] = []; //tạo mảng rổng nếu chưa có
        } else {
            $spFromDB = $this->model('detailmodel')->getallbyid($id);  //if ($spFromDB==null) ...s

            if (isset($_SESSION['giohang'][$id])) {
                $_SESSION['giohang'][$id]['quantity']++;
                echo $_SESSION['giohang'][$id]['quantity'];
            } else {
                $_SESSION['giohang'][$id] = [
                    'TenSP' => $spFromDB['TenSP'],
                    'Gia' => $spFromDB['GiaMoi'],
                    'quantity' => 1
                ];
                echo '<tr>
                                <td data-id="' . $id . '">' . $spFromDB['TenSP'] . '</td>
                                <td>' . $spFromDB['GiaMoi'] . '</td>
                                <td class="soluong">' . $_SESSION['giohang'][$id]['quantity'] . '</td>
                            </tr>';
            }
        }
    }
    function select()
    {
        $sp = $this->model('adminmodel');
        // $spFromDB = $this->model('detailmodel')->getallbyid($id);
        echo "<tr><td scope=' row'>#</td>"
            . "<td><input type='text' name='tensp' placeholder='nhập tên SP'></td>"
            . "<td><input type='text' name='giaCu' placeholder='nhập Giá củ'></td>"
            . "<td><input type='text' name='giamoi' placeholder='nhập Giá mới'></td>"
            . '<td><input type="text" name="giotinh" placeholder="nhập Giới tính"></td>
        <td><select name="MaNSX"><option>chọn NSX</option>';
        foreach ($sp->getnsx() as $nsx) {
            echo '<option value="echo ' . $nsx['MaNSX'] . '"> ' . $nsx['TenNSX'] . '</option>';
        }
        echo  '</select>
        </td>
        <td>
            <select name="loaisp">
                <option>chọnLoại</option>';
        foreach ($sp->getloai() as $loai) {
            echo  '<option value=" ' . $loai['MaLoai'] . '"> ' . $loai['TenLoai'] . '</option>';
        }
        echo  '
                </select>
            </td>
            <td><input type="file" name="anhchinh">
            <td>
                <p>thêm ít nhất 3 ảnh</p>
                <input type="file" name="anhphu[]" multiple="multiple">
            </td>
            <td>
                <a href="' . BASE_URL . 'admin' . '." class="btn btn-outline-danger">hủy</a>
                <input type="submit" class="btn btn-outline-success" value="Thêm sp" name="submit">
            </td>
        </tr>';
    }
    function addsp()
    {
        $sp = $this->model('adminmodel');
        $this->view('trang3', [
            'login' => $this->ktlogin(),
            'action' => 'add',
            'tag' => [
                'change',
            ],
        ]);
    }
    function addkh()
    {
        $sp = $this->model('adminmodel');
        $this->view('trang3', [
            'login' => $this->ktlogin(),
            'action' => 'add',
            'tag' => [
                'changekh',
            ],
        ]);
    }
    function changesp()
    {
        $sp = $this->model('adminmodel');
        $this->view('trang3', [
            'sanpham' => $sp->getallbyid($_POST['id']),
            'login' => $this->ktlogin(),
            'action' => 'change',
            'nsx' => $sp->getnsx(),
            'loai' => $sp->getloai(),
            'tag' => [
                'change',
            ],
        ]);
    }
    function changekh()
    {
        $kh = $this->model('adminmodel');
        $this->view('trang3', [
            'kh' => $kh->getallkhbyid($_POST['id']),
            'login' => $this->ktlogin(),
            'action' => 'change',
            'tag' => [
                'changekh',
            ],
        ]);
    }
}

<style>
    .nav-ul>li {
        position: relative;
        margin: 0 3rem;
        padding: 0 10px;
        width: 10rem;
        text-align: center;
        font-size: 1.8rem;
        text-transform: capitalize;
    }

    .nav-ul>li:hover {
        background-color: rgb(228, 228, 228);
    }

    .nav-ul li ul li:hover a {
        color: white;
    }

    .nav-ul>li:hover>ul {
        display: block;
    }

    .nav-ul li ul {
        padding: 0;
        position: absolute;
        top: 100%;
        width: 10rem;
        left: 0;
        margin: 0;
        z-index: 10;
        display: none;
    }

    .nav-ul li ul li {
        text-align: center;
        padding: 0.5rem 10px;
        background-color: #fff;
        background-color: rgb(228, 228, 228);
    }

    .nav-ul li ul li:hover {
        background-color: rgb(247, 71, 71);
    }

    .cart {
        position: relative;
    }

    .bag {
        position: absolute;
        right: 0;
        top: 100%;
        z-index: 12;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }

    .table td,
    .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
        color: #212529;
        background-color: rgba(0, 0, 0, .075);
    }


    .table-dark {
        color: #fff;
        background-color: #343a40;
    }

    .table-dark,
    .table-dark>td,
    .table-dark>th {
        background-color: #c6c8ca;
    }



    table {
        border-collapse: collapse;
    }

    .table-dark td,
    .table-dark th,
    .table-dark thead th {
        border-color: #454d55;
    }

    .table-dark tbody+tbody,
    .table-dark td,
    .table-dark th,
    .table-dark thead th {
        border-color: #95999c;
    }

    .table-dark {
        color: #fff;
        background-color: #343a40;
    }

    th {
        text-align: inherit;
    }



    th {
        text-align: inherit;
    }

    th {
        display: table-cell;
        vertical-align: inherit;
        font-weight: bold;
        text-align: -internal-center;
    }

    .table-dark.table-hover tbody tr:hover {
        color: #fff;
        background-color: rgba(255, 255, 255, .075);
    }

    td {
        white-space: nowrap;
    }
</style>
<header class="row">
    <div class="col head-center l-4 l-o-4 ">
        <strong><?php echo $data['ngay']; ?></strong>
    </div>
    <div class="col l-4 m-0 c-0">
        <div class="head-right">
            <div class="find-store">
                <?php echo $data['login'] == FALSE ? ' ' : 'xin chào ' . $data['login'] ?>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="Language">
                <div class="img">
                </div>
                <span>VN</span>
            </div>
        </div>
    </div>
</header>
<nav>
    <div class="nav">
        <div class="nav col nav l-6 m-6 c-3 ">
            <div class="logo">
                <a href="<?= BASE_URL ?>"><img src="<?= BASE_URL ?>img/logo.png" alt=" "></a>
            </div>
            <div class="nav-bar">
                <ul class="nav-ul">
                    <?php
                    foreach ($data['NhaSX'] as $NhaSX) {
                        $string  = '<li class="nav-item"> <a href="' . BASE_URL . 'product?mnsx=' . $NhaSX['MaNSX'] . '">' . $NhaSX['TenNSX'] . ' </a> <ul> ';
                        foreach ($data['loaisp'] as $loaisp) {
                            $string .= '<li class="nav-item"><a href="' . BASE_URL . 'product?mnsx=' . $NhaSX['MaNSX'] . '&maloai=' . $loaisp['MaLoai'] . '">' . $loaisp['TenLoai'] . ' </a></li> ';
                        }
                        $string .= '</ul> </li>';
                        echo $string;
                    }
                    ?>
                </ul>

            </div>
        </div>

        <div class="use col  l-6 m-6 c-9">
            <div class="seach">
                <input type="text" placeholder="tìm kiếm">
                <div class="line"></div>
                <i class="fas fa-search"></i>
            </div>

            <?php if ($data['login'] == FALSE) {
                echo    '<a class="sign-in" href=" ' . BASE_URL . 'buyer/login">
                <i class="far fa-user"></i>
                        <span>Đăng nhập</span></a>
                        <a class="sign-in" href="' . BASE_URL . 'buyer/regiter">
                                <span>Đăng Ký</span></a>';
            } else {
                echo '<a class="sign-in" href="' . BASE_URL . 'home?dangxuat=TRUE">
                <i class="far fa-user"></i>
                        <span>Đăng Xuất</span></a><a class="sign-in" href="' . BASE_URL . 'buyer/changePassword">
                        <span>Đổi pass</span></a>';
            } ?>


            <div class="cart">
                <a href="<?= BASE_URL ?>bag"><i class="fas fa-shopping-cart"></i></a>
                <section class="bag">
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <th>Tên Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Số Lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['giohang'])) :
                                foreach ($_SESSION['giohang'] as $key => $value) :
                            ?>
                                    <tr>
                                        <td data-id="<?php echo $key ?>"><?= $_SESSION['giohang'][$key]['TenSP'] ?></td>
                                        <td><?= $_SESSION['giohang'][$key]['Gia'] ?></td>
                                        <td class="soluong"><?= $_SESSION['giohang'][$key]['quantity'] ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>

                </section>
            </div>
            <div class="bar">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>

    <div class="seach-tablet">
        <input type="text" placeholder="tìm kiếm" name="" id="">
        <div class="line"></div>
        <i class="fas fa-search"></i>
    </div>
</nav>
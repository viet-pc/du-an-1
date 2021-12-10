<style>
    .thongbaohet {
        font-size: 3rem;
        color: #dc3545;
    }
</style>
<div class="row product" id="list_products">
    <div class="filter_category col l-3">
        <div class="list-filter">
            <ul>
                <li>loại giày</li>
                <li>mày sắc</li>
                <li>size lớn</li>
                <li>size nhỏ</li>
            </ul>
        </div>
    </div>
    <div class="product-grid">
        <header>
            <div class="name">
                <h4>New Gear<span>(400)</span></h4>
            </div>
            <div class="filter">
                <div class="hidefilter">
                    <span class="text"> Hide Filter</span>
                </div>
                <div class="sort">
                    <select>
                        <option>Sắp xếp theo</option>
                        <option value="">Giá: thấp đến cao</option>
                        <option value="">Giá: cao đến thấp</option>
                    </select>
                </div>
            </div>
        </header>
        <div class="box-item">
            <?php
            if ($data['listproduct'] == '') {
                echo "<p class='thongbaohet'>hết loại sản phẩm đó</p>";
            } else {
                foreach ($data['listproduct'] as $product) :
            ?>
                    <a href="<?php echo BASE_URL . 'details?id=' . $product['MaSP'] ?>" class="item">
                        <div class="image">
                            <img src="<?php echo BASE_URL . 'img/' . $product['anh1'] ?>" alt="">
                        </div>
                        <div class="information">
                            <div class="name">
                                <h6><?php echo $product['TenSP'] ?></h6>

                            </div>
                            <span class="price">
                                <?php echo $product['GiaMoi'] ?>
                            </span>
                            <span class="set"><?php echo $product['TenLoai'] . '   ' . $product['TenNSX'] ?></span>
                            <div class="img-color">
                                <img onmouseover="chuyenanh(this)" src="<?php echo BASE_URL . 'img/' . $product['anh2'] ?>" alt="">
                                <img onmouseover="chuyenanh(this)" src="<?php echo BASE_URL . 'img/' . $product['anh3'] ?>" alt="">
                                <img onmouseover="chuyenanh(this)" src="<?php echo BASE_URL . 'img/' . $product['anh4'] ?>" alt="">
                            </div>
                        </div>
                    </a>
            <?php
                endforeach;
            }
            ?>
        </div>
        <!-- <footer>
            <p class="text">
                Bạn đã xem 24 trong số 420 mặt hàng
            </p>
            <button>
                load 24 more
            </button>
        </footer> -->
    </div>
</div>
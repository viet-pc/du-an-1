<div class="you-look">
    <div class="text">
        <span>Tạo vẻ ngoài của bạn</span>
    </div>
    <div class="product ">
        <div class="icon icon-right" onclick="right(this)">
            <i class="fas fa-chevron-right"></i>
        </div>
        <div class="icon icon-left" onclick="left(this)">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="row review sm-gutter">
            <?php
            foreach ($data['sp'] as $data) :
            ?>
                <a class="item col l-4 m-4 c-6" href="<?php echo BASE_URL . 'details?id=' . $data['MaSP'] ?>">
                    <div class="image">
                        <img src="<?php echo BASE_URL . 'img/' . $data['anh1'] ?>" alt="">
                    </div>

                    <div class=" name-prive">
                        <strong class="name">
                            <?php echo $data['TenSP']; ?>
                        </strong>
                        <strong class="price">
                            <?php echo  number_format($data['GiaMoi'], 0, ',', '.') . 'đ' ?>
                        </strong>
                    </div>
                    <span class="set">
                        Nam
                    </span>
                </a>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <div class="show-all row">
        <button class="col l-3 m-12 c-12">Xen tất cả</button>
    </div>
</div>
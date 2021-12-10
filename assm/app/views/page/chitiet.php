<?php
$kq = $data['kq'];
?>

<style>
    .giacu {
        text-decoration: line-through;
    }
</style>

<div class="tt row">
    <div class="image col l-8">
        <img src="<?= BASE_URL . 'img/' . $kq['anh1']; ?>" alt="">
        <img src="<?= BASE_URL . 'img/' . $kq['anh2']; ?>" alt="">
        <img src="<?= BASE_URL . 'img/' . $kq['anh3']; ?>" alt="">
        <img src="<?= BASE_URL . 'img/' . $kq['anh4']; ?>" alt="">
    </div>
    <div class="addcard col l-4">
        <div class="name">
            <div class="text">
                <h1><?php echo $kq['TenSP']; ?></h1>
                <span class="giacu"><?php echo  number_format($kq['GiaCu'], 0, ',', '.') . 'đ' ?></span>
            </div>
            <div class="price"><?php echo  number_format($kq['GiaMoi'], 0, ',', '.') . 'đ' ?></div>
        </div>
        <div class="select-type">
            <img src="<?= BASE_URL . 'img/' . $kq['anh3']; ?>" alt="">
            <img src="<?= BASE_URL . 'img/' . $kq['anh4']; ?>" alt="">
        </div>
        <div class="name-type">
            Color: Black with grey
        </div>
        <div class="Select-size">
            <h4>Select-size</h4>
            <div class="size">
                <div class="box-size">
                    <p>36</p>
                </div>
                <div class="box-size">
                    <p>37</p>
                </div>
                <div class="box-size">
                    <p>38</p>
                </div>
                <div class="box-size">
                    <p>39</p>
                </div>
                <div class="box-size">
                    <p>40</p>
                </div>
                <div class="box-size">
                    <p>41</p>
                </div>
                <div class="box-size">
                    <p>42</p>
                </div>
                <div class="box-size">
                    <p>43</p>
                </div>
                <div class="box-size">
                    <p>44</p>
                </div>
            </div>
        </div>
        <div class="btn">
            <button id="addtocard" data-id="<?= $kq['MaSP'] ?>">Add to card</button>
        </div>
        <div class="reviews">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <p class="text">
                <?= $kq['views']; ?> Lược Xem
            </p>
        </div>
        <div class="support">
            <i class="far fa-comment-alt"></i>
            <span>Need help?</span>
        </div>
        <div class="support">
            <i class="far fa-heart"></i>
            <span>
                Add to wish list
            </span>
        </div>
        <div class="taitel">
            Free shipping on orders of $50+
        </div>
    </div>
</div>
<html>

<head>
    <base href="http://localhost/Php1/assm/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Viet Pham</title>
    <link href="<?= BASE_URL ?>css/grid.css" rel="stylesheet" type="text/css" />
    <link href="<?= BASE_URL ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>js/ajax.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c212fbd740.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container grid">
        <?php
        include_once 'block/header.php';
        if (isset($data['page'])) {
            include_once 'page/' . $data['page'] . '.php';
        };
        if (isset($data['tag'])) {
            foreach ($data['tag'] as $value) {
                include_once 'block/' . $value . '.php';
            }
        };
        include_once 'block/footer.php';
        ?>
    </div>

</body>
<script src="<?php echo BASE_URL . '/js/main.js'; ?>"></script>

</html>
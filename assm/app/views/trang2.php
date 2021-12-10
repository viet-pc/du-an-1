<!doctype html>
<html lang="en">

<head>
    <title>admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>/js/admin.js"></script>
    <!-- <style>
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
            display: flex;
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
    </style> -->
    <style>
        input {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        include_once 'admin/nav.php';
        if (isset($data['tag'])) {
            foreach ($data['tag'] as $value) {
                include_once 'admin/' . $value . '.php';
            }
        };
        ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

</body>
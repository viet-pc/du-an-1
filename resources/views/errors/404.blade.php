<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eror 404</title>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <style>

        html {
            height: 100%;
            z-index:-1;
        }

        body {
            height: 100%;
            background: url("https://wallpapercave.com/wp/6SLzBEY.jpg") no-repeat left top;
            background-size: cover;
            overflow: hidden;

            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
        }

        .text h1 {
            color: #009ba3;
            margin-top: -200px;
            font-size: 15em;
            text-align: center;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7), -10px 10px 0px rgba(0, 0, 0, 0.4), -15px 15px 0px rgba(0, 0, 0, 0.2);
            font-family: monospace;
            font-weight: bold;
        }

        .text h2 {
            color: #9df2fc;
            font-size: 5em;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7);
            text-align: center;
            margin-top: -150px;
            font-family: monospace;
            font-weight: bold;
        }

        .text h3 {
            color: white;
            margin-left: 30px;
            font-size: 2em;
            text-shadow: -5px 5px 0px rgba(0, 0, 0, 0.7);
            margin-top: -40px;
            font-family: monospace;
            font-weight: bold;
            text-align: center;
        }

        .torch {
            margin: -350px 0 0 -350px;
            width: 600px;
            height: 600px;
            box-shadow: 0 0 0 9999em #000000f7;
            opacity: 1;
            border-radius: 50%;
            position: fixed;
            background: rgba(0, 0, 0, 0.3);

        &
        :after {
            content: '';
            display: block;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            box-shadow: inset 0 0 40px 2px #000,
            0 0 20px 4px rgba(13, 13, 10, 0.2);
        }

        }
        button{
            z-index: 2;
        }

        button:hover{
        cursor: pointer;
        }
    </style>

</head>

<script>
    $(document).mousemove(function (event) {
        $('.torch').css({
            'top': event.pageY,
            'left': event.pageX
        });
    });
</script>
<body>

<div class="text">
    <h1>404</h1>
    <h2>Oops!!</h2>
    <h3>Chúng tôi không tìm thấy thứ bạn đang tìm </h3>
    <br>
    <h3>Nơi đây tối và đáng sợ quá 😱!!</h3>

</div>
<div class="torch"></div>
</body>

</html>


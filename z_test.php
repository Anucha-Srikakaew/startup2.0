<html>

<head>

    <style>
        .box {
            width: 100px;
            height: 100px;
        }

        .img1 {
            position: absolute;
            background-image: url('https://www.devdit.com/chmod/post/images/26325652333.jpg');
            background-size: contain;
            border: solid 1px green;
        }

        .img2 {
            background-image: url('https://www.devdit.com/chmod/post/images/26325652335.jpg');
            position: absolute;
            background-size: contain;
            top: 15px;
            left: 15px;
            border: solid 1px blue;
        }

        .img3 {
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZZ3RmLq8xqrBIOixXNwy6SDUhxJh5pV_jCTEp9jNl&s');
            position: absolute;
            background-size: contain;
            top: 20px;
            left: 20px;
            border: solid 1px blue;
        }

        .div123 {
            position: absolute;
            width: 100px;
            height: 100px;
            background: red;
            transition: all 0.5s ease-in-out;
        }

        .div123:hover {
            background: blue;
            position: relative;
            width: 300px;
        }
    </style>

</head>

<body>
    <div class="box img1"></div>
    <div class="box img2"></div>
    <div class="box img3"></div>

    <br><br><br><br><br><br><br>

    <div class="div123"></div>
    <br><br><br><br><br><br><br><br>
    <div class="div123"></div>
</body>

</html>
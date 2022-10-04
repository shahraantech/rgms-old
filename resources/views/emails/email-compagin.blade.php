<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shahraan Tech</title>

    <style>
        .logo {
            text-align: center;
        }

        .logo img {
            width: 200px;
        }

        .company {
            text-align: center;
            font-style: bold;

        }

        .sender {
            margin-left: 100px;

        }

        .content {
            width: 75%;
            margin-left: 170px;

            font-size: 1.2rem;


        }

        .company-addres {
            background-color: black;
            color: blanchedalmond;
            padding: 50px;
            margin: 100px;

        }

        b {
            float: right;
        }
    </style>
</head>

<body>
    {{ $details['subject'] }}
    <p class="content">
        {!! $details['text_body'] !!}
    </p>

</body>

</html>

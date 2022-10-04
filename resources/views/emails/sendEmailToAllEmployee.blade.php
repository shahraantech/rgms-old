<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Hiring Notification</title>

    <style>
        .logo{
            text-align: center;
        }
        .logo img{
            width: 200px;
        }
        .company{
            text-align: center;
            font-style: bold;

        }
        .sender{
            margin-left: 100px;

        }
        .content{
            width: 75%;
            margin-left: 170px;

            font-size: 1.2rem;


        }
        .company-addres{
            background-color: black;
            color: blanchedalmond;
            padding: 50px;
            margin: 100px;

        }
        b{
            float: right;
        }
    </style>
</head>
<body>

<h1 class="company">New Employee Announcement</h1>
<h3 class="sender">Hi all!</h3>
<p class="content">
  I am very pleased to announce that {{$data['employee']->name}} will be joining us as a Web Developer on [date]

   [name] will work with Development Dept . [He/she] previously worked at/in [add information about employment background.] [He/ She] recently graduated from [insert information academic background.]

    Please come to meet Salman Raza on 01 Oct 2021  and welcome [him/her] to the team!

</p>
<h3 class="sender">Best regards,
<br>
    Sajid Hussain Raza,<br>
    Chief Technical Officer
</h3>

</body>
</html>

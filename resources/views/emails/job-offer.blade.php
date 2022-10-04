<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
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
            font-family: 'Courier New', Courier, monospace;
        }
        .sender{
            margin-left: 100px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .content{
            width: 75%;
            margin-left: 170px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
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

<h1 class="company">Job Offer Letter</h1>
<h3 class="sender">Dear {{ $details['name'] }} <br>Congratulation!</h3>
<p class="content">
    We are highly pleased to inform you that your application process and interview have been successful due to which you are being offered a job as
    a <b>{{ $details['position'] }}</b> at Alpha Buzz Co. You will start this job as a proportionally periods of <b>{{ $details['prob_period'] }} </b> months after which you will be offered full time permanent job
    according to your skills and requirements. The joining date will be <b>{{ $details['doj'] }}</b>.

    You are requested to visit the company and submit all the required documents so, that you can start off with this job.

    We are looking forward to working with you and we hope that we work as the best team members and make our company more successful. We wish you the best of luck for starting with this huge opportunity.

</p>
<h3 class="sender">Thank You,<br>
    Sajid Hussain Raza,<br>
    Chief Technical Officer
</h3>
<h4 class="company-addres" style="margin-left:2.5em">
    Company Name:  <b>Alpha Buzz Co (ABC)</b>  <br><br><br>
    Phone:               <b> +92 309 9948884 | +92 304 1620156</b>   <br><br><br>
    Email:               <b>  info@alphabuzzco.pk</b>
    Address:             <b>The A Team Trading Hub, 61-commercial XX, DHA Phase-3, Lahore</b>   <br> <br><br>
    Location:            <b> https://goo.gl/maps/JvS2ntEgzZXJrzWFA</b>
    Business Hours:  <b>  10 am – 06 pm</b>

</h4>
</body>
</html>

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

<h3 class="sender">Dear {{$details['name']}}</h3>
<p class="content">
   I would like to thank you for applying for the position of <b>{{$details['position']}}</b>. It was a pleasurable to learn more about your skills and accomplishments.
    </p>
<p class="content">
Due to the high caliber of applicants and the specific requirements of the position, you have been unsuccessful at this time.
    This decision, however, does not reflect on your ability and we encourage you to apply for a position with this company in the future.
<p class="content">
   <p class="content">
The company would like to file your resume for future reference in case a similar position becomes available, so we can contact you.

Thanks again for your interest in Alpha Buzz Co and best of luck with your job search.
On behalf of the company, I would like to thank you for your time.

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

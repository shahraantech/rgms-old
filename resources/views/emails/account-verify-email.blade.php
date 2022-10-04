<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM</title>
</head>
<body>

<h1 class="company">Account Verifications</h1>
<h3 class="sender">Dear {{ $details['name'] }} </h3>
<p class="content">
    @php $id=encrypt($details['id']) @endphp
   Your username is: {{ $details['email'] }} and password is:iub12345678</p>
    
    <a href="{{url('verify-account/').'/'.$id}}">Verify Your Account</a>
   
    
</body>
</html>

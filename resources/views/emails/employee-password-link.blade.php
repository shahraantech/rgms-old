<!DOCTYPE html>
<html>
<head>
    <title>Alpha Buzz</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
    <p>{{ $details['token'] }}</p>
    <p>{{ $details['email'] }}</p>
    <a href="{{url('emp-reset-password/'.$details['token'] .'/'.$details['email'] )}}">Reset Password</a>


</body>
</html>



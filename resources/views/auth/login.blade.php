
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>RGMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('public/assets/auth/login-page/css/my-login.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/img/logo/favicon.png') }}">
</head>

<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">

                <div class="card fat" style="margin-top: 100px">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>
                        @if ($message = Session::get('error'))
                            <span class="text-center text-danger"> {{ $message }}</span>
                        @endif
                            <form method="POST" action="{{ route('login') }}" id="LoginForm" class="my-login-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                                <div class="invalid-feedback">
                                    Email is invalid
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <input type="hidden" name="address" id="address">
                            <div class="form-group">
                                <label for="password">Password
                                    <a href="{{url('password/reset')}}" class="float-right">
                                        Forgot Password?
                                    </a>
                                </label>
                                <input id="password" type="password" class="form-control" name="password" required data-eye>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                    <label for="remember" class="custom-control-label">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block btn-login">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; 2022 &mdash; Shahraan Tech Pvt Ltd
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('public/assets/auth/login-page/js/my-login.js')}}"></script>

</body>


<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>

<script type="text/javascript" defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY904LGu2DEpfjOloBWBtPof8Zx8e6gyQ"></script>

<script>

    $('.btn-login').on('click', function() {
        $(".btn-login").prop("disabled", true);
        $(".btn-login").html("Please wait...");
        $('#LoginForm').submit();
    });
</script>


<script type="text/javascript">
    navigator.geolocation.getCurrentPosition(function(position) {
        $("#show_location").html("Latitude: " + position.coords.latitude + " </br>Longitude:" + position.coords
            .longitude);

            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

        fetch("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + position.coords.latitude + "," +
                position.coords.longitude + "&key=AIzaSyAY904LGu2DEpfjOloBWBtPof8Zx8e6gyQ&sensor=true")
            .then(response => response.json()
                .then(data => {
                    var address = data.results[0]['formatted_address'];
                    var myString = address.substring(address.indexOf(' ') + 1);

                    document.getElementById('address').value = myString;

                    var address1 = data.results[0].address_components[1].long_name;
                    var address2 = data.results[0].address_components[2].long_name;
                    var address3 = data.results[0].address_components[3].long_name;

                    $("#show_Address").html("Address:" + myString);
                })
            );
    });


</script>
</html>

Iub@55853557

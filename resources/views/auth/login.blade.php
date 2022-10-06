<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RGMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('public/assets/auth/login-page/css/main.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/img/logo/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body class="my-login-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="contant" class="col-md-7 col-lg-8 animate__animated animate__slideInLeft">
                <h1>RGMS</h1>
                <h2>Realtor Growth Management System</h2>
                <p>Pakistan's no. 1</p>
                <p>Real Estate CRM</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
            <div id="login" class="card">
                <div class="card-body">
                    <h4 class="card-title">Login</h4>
                    @if ($message = Session::get('error'))
                        <span class="text-center text-danger"> {{ $message }}</span>
                    @endif
                    <form method="POST" action="{{ route('login') }}" id="LoginForm" class="my-login-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input id="email" type="email" class="form-control mt-3 mb-3" name="email" value=""
                                   required autofocus>
                            <div class="invalid-feedback">
                                Email is invalid
                            </div>
                        </div>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="address" id="address">

                        <div class="form-group mt-3 mb-3">
                            <label for="password">Password
                                <a href="{{url('password/reset')}}" class="float-right">
                                    Forgot Password?
                                </a>
                            </label>
                            <input id="password" type="password" class="form-control mt-3 mb-3" name="password"
                                   required data-eye>
                            <div class="invalid-feedback">
                                Password is required
                            </div>
                        </div>

                        <div class="form-check mt-3 mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>

                        <div class="form-group mt-3 mb-3">
                            <button type="submit" class="btn btn-primary form-control btn-login">
                                Login
                            </button>
                        </div>
                        <div class="mt-4 text-center">
                            Don't have an account? <a href="{{url('register')}}">Create One</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="footer m-auto mt-3">
    Copyright &copy; 2022 &mdash; Shahraan Tech Pvt Ltd
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{ asset('public/assets/auth/login-page/js/my-login.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

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
</body>

</html>

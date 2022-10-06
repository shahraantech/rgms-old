<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RGMS</title>

    <link rel="stylesheet" href="{{ asset('public/assets/auth/login-page/css/register.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/auth/login-page/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('public/assets/auth/login-page/css/animate.css')}}">

</head>

<body class="my-login-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div id="contant" class="col-md-7 col-lg-8 animate__animated animate__slideInLeft">
                <h1>RGMS</h1>
                <h2>Realtor Grouth Management System</h2>
                <p>Pakistan's no. 1</p>
                <p>Real Estate CRM</p>
            </div>
        </div>
        <div class="col-md-5 col-lg-7">
            <div id="login" class="card">
                <div class="card-body">
                    <h4 class="card-title">Register</h4>
                    <form method="POST" class="my-login-validation" novalidate="" action="{{url('signup')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">

                                <input  type="text" class="form-control mt-3 mb-3" name="name"
                                       required autofocus placeholder="Enter Your Name">
                                <div class="invalid-feedback">
                                    Name is invalid
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <input  type="text" class="form-control mt-3 mb-3" name="contact"
                                       required autofocus placeholder="Enter Your Contact">
                                <div class="invalid-feedback">
                                    Contact is invalid
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <input type="email" class="form-control mt-3 mb-3" name="email"
                                       required data-eye placeholder="Enter Your Email">
                                <div class="invalid-feedback" >
                                    Password is required
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <input  type="password" class="form-control mt-3 mb-3" name="password"
                                       required data-eye placeholder="Enter Your Password">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-6">
                                <input type="text" class="form-control mt-3 mb-3" name="country_name"
                                       required data-eye placeholder="Enter Your Country">
                                <div class="invalid-feedback" >
                                    Country is required
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <input  type="text" class="form-control mt-3 mb-3" name="company_name"
                                       required data-eye placeholder="Enter Your Company Name">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3 mb-3">
                            <button type="submit" class="btn btn-primary form-control">
                                Register
                            </button>
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
<script src="js/bootstrap.js"></script>
</body>

</html>

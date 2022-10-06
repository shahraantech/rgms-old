<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
      <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
              <form action="{{route('paypal_call')}}" method="post">
                 @csrf
                  <div class="form-group">
                      <button class="btn btn-success" type="submit">Pay with Paypal</button>
                  </div>
              </form>
          </div>
          <div class="col-md-3"></div>
      </div>
       
    </body>
</html>

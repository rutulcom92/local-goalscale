<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .v-align-middle{
            /* height: calc(100vh - 24px); */
            height: 82vh;
            display: flex;
            width: 100%;
        }
        .error-message-description h5{
            font-weight: 500;
            color: rgba(255, 255, 255, 0.87);
            margin: 40px 0;
        }
    </style>
</head>
<body class="login_wrap_bg">
    <div id="app">
        <div class="login-wrap_main">
            <div class="login-wrap_innerx">
                <div class="flw text-center align-self-center">
                    <div class="logo_client"><img src="{{ asset('images/gas-logo@2x.png') }}"></div>
                    <div class="flw"><h1>@yield('code') - @yield('message')</h1></div>
                    
                    <div class="error-message-description"><h5>@yield('error-description')</h5></div>
                    <div class="form-group">
                        <a href="{{ route('login') }}" class="btnsgn Transbtn">Go Home</a>
                    </div>
                </div>   
            </div>
       </div>
   </div>
</body>
</html>
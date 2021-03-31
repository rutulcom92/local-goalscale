<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('images/wmu_favicon.png') }}" type="image/png" sizes="32x32">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="login_wrap_bg">
    <div id="app">
    <div class="login-wrap_main">
    <div class="login-wrap_innerx">
      <div class="login-wrap">
          <div class="logo_div">
              <a href="{{ url('/') }}"><img src="{{ asset('images/gas-logo@2x.png') }}"></a>
          </div>
      </div>
        @yield('content')
        </div> 
    </div>    
    </div>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/auth.js') }}" defer></script>
</body>
</html>
